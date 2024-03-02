<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Enums\GeneralStatus;
use Exception;
use Auth;
use App\Banner;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'DESC')->get();
        $title = 'Brands Listing';
        return view('admin.banners.index', compact('banners', 'title'));
    }

    /**
     * helper function to slug the category name
     *
     * @return \Illuminate\Http\Response
     */
    public function slugit($str, $replace=array(), $delimiter='-') {
		if ( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		return $clean;
	}    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Banner $banner)
    {
        $title = 'Add New Banner';
        $banner->status = GeneralStatus::Enabled;
        return view('admin.banners.create', compact('title', 'banner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {
            $banner = new Banner();
            $banner->title = $request->title;
            $banner->description = $request->description;
            $banner->slug = $this->slugit($request->title);
            $banner->anchor_label = isset($request->anchor_label)?$request->anchor_label:NULL;
            $banner->anchor = isset($request->anchor)?$request->anchor:NULL;
            $banner->image = ''; //since its not null
            $banner->status = $request->status;
            $banner->created_by = Auth::guard('admin')->user()->id;
            $banner->save();
            
            if ($request->hasFile('image')) {                
                $imagePath = $this->uploadBannerAsset($banner, $request);
                $banner->image = $imagePath;
                $banner->save();                
            }

            DB::commit();
            return redirect()->action('Admin\BannerController@index')->withErrors(['alert-success'=>"Banner added successfully"]);
        } catch (\Exception $e) {

            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\BannerController@index')->withErrors(['alert-danger'=>"Failed to add banner."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        try {            	                                 	
            $title = 'View Banner Detail';
            return view('admin.banners.show', compact('banner', 'title'));	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\BannerController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\BannerController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $title = 'Edit Banner';
        return view('admin.banners.edit', compact('title', 'banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {           
            $banner->title = $request->title;
            $banner->description = $request->description;
            $banner->slug = $this->slugit($request->title);
            $banner->anchor_label = $request->anchor_label;
            $banner->anchor = $request->anchor;
            $banner->status = $request->status;
            $banner->updated_by = Auth::guard('admin')->user()->id;
            $banner->save();

            if ($request->hasFile('image')) {                
                $imagePath = $this->uploadBannerAsset($banner, $request);                
                $banner->image = $imagePath;
                $banner->save();                
            }

            DB::commit();
            return redirect()->action('Admin\BannerController@index')->withErrors(['alert-success'=>"Banner updated successfully"]);
        } catch (\Exception $e) {
            
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\BannerController@index')->withErrors(['alert-danger'=>"Failed to updating banner."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        if( $banner->image ) {
            $this->removeAsset( $banner->image );
        }        
        
        $banner->delete();
        return redirect()->action('Admin\BannerController@index')->withErrors(['alert-success'=>"Banner deleted successfully."]);
    }

    /**
     * Get the file
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function removeAsset($image)
	{
        $directory = public_path('uploads/banners/');
        $thumbdirectory = public_path('uploads/banners/thumb/');
        $imagePath = $directory . $image;
        $thumbPath = $thumbdirectory . $image;
        
		if (!empty($image) && file_exists($imagePath)) {			
			File::delete($imagePath);
		}				
		if (!empty($image) && file_exists($thumbPath)) {			
			File::delete($thumbPath);
		}				
		return true;
	}

    /**
     * upload category assets
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function uploadBannerAsset($data, REQUEST $request)
	{        
        $resize = ['full' => array(1920, null), 'thumb' => array(768, null)];
        $name = 'image';
        $directory = public_path('uploads/banners/');
		$thumbdirectory = public_path('uploads/banners/thumb/');
        
        $filename = $this->uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory);

		return $filename;		
    }
    
    /**
     * upload the assets
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory)
	{
		if (is_object($data) && !empty($data)) {
			if(!empty($data->$name) && file_exists($directory.$data->$name)){
				$path1 = $directory . $data->$name;
				File::delete($path1);
			}
			if(!empty($data->$name) && file_exists($thumbdirectory.$data->$name)){
				$path2 = $thumbdirectory . $data->$name;
				File::delete($path2);
			}			
		}

		if (!file_exists($directory)) {
			mkdir($directory, 0777, true);
		}
		if (!file_exists($thumbdirectory)) {
			mkdir($thumbdirectory, 0777, true);
		}
		
		$fileName = uniqid() . '.' . $request->file($name)->getClientOriginalExtension();		
		$fileNameDir = $directory . '/' . $fileName;
		$upload = Image::make($request->file($name));
		$upload->resize($resize['full'][0], $resize['full'][1], function ($constraint) {
			$constraint->aspectRatio();
		});
		$upload->save($fileNameDir, 100);

		$fileThumbNameDir = $thumbdirectory . '/' . $fileName;
		$upload->resize($resize['thumb'][0], $resize['thumb'][1], function ($constraint) {
			$constraint->aspectRatio();
		});
		$upload->save($fileThumbNameDir, 100);

		return $fileName;		
    }
}

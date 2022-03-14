<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use Exception;
use Auth;
use App\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        $title = 'Brands Listing';
        return view('admin.brands.index', compact('brands', 'title'));
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
    public function create()
    {
        $title = 'Add New Brand';
        return view('admin.brands.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $this->slugit($request->name);
            $brand->status = $request->status;
            $brand->created_by = Auth::guard('admin')->user()->id;
            $brand->save();

            if ($request->hasFile('image')) {                
                $imagePath = $this->uploadCategoryAsset($brand, $request);
                $brand->image = $imagePath;
                $brand->save();                
            }

            DB::commit();
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-success'=>"Brand added successfully"]);
        } catch (\Exception $e) {
            
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-danger'=>"Failed to add brand."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Brand $brand )
    {
        try {            	                                 	
            $title = 'View Brand Detail';
            return view('admin.brands.show', compact('brand', 'title'));	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Brand $brand )
    {        
        $title = 'Edit Brand';
        return view('admin.brands.edit', compact('title', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {           
            $brand->name = $request->name;
            $brand->slug = $this->slugit($request->name);
            $brand->status = $request->status;
            $brand->updated_by = Auth::guard('admin')->user()->id;
            $brand->save();

            if ($request->hasFile('image')) {                
                $imagePath = $this->uploadCategoryAsset($brand, $request);                
                $brand->image = $imagePath;
                $brand->save();                
            }

            DB::commit();
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-success'=>"Brand updated successfully"]);
        } catch (\Exception $e) {
            
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-danger'=>"Failed to updating brand."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if( $brand->products->IsNotEmpty() ) {
            return redirect()->action('Admin\BrandController@index')->withErrors(['alert-danger'=>"Brand associated to product."]);
        }
        if( $brand->image ) {
            $this->removeAsset( $brand->image );
        }        
        
        $brand->delete();
        return redirect()->action('Admin\BrandController@index')->withErrors(['alert-success'=>"Brand deleted successfully."]);
    }

    /**
     * Get the file
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function removeAsset($image)
	{
        $directory = public_path('uploads/brands/');
        $thumbdirectory = public_path('uploads/brands/thumb/');
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
    
    /**
     * upload category assets
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function uploadCategoryAsset($data, REQUEST $request)
	{        
        $resize = ['full' => array(800, null), 'thumb' => array(640, null)];
        $name = 'image';
        $directory = public_path('uploads/brands/');
		$thumbdirectory = public_path('uploads/brands/thumb/');
        
        $filename = $this->uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory);

		return $filename;		
	}
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Category;
use Exception;
use Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Enums\GeneralStatus;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('category_id', 'DESC')->get();
        $title = 'Categories Listing';
        return view('admin.categories.index', compact('categories', 'title'));
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
        $categories = Category::pluck('category_name','category_id');
        $categoryStatuses = GeneralStatus::toSelectArray();
        $title = 'Add New Category';
        return view('admin.categories.create', compact('categories', 'categoryStatuses', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {
            $category = new Category();
            $category->category_name = $request->category_name;
            $category->parent_category_id = isset($request->parent_category_id)?$request->parent_category_id:0;
            $category->category_description = $request->category_description;
            $category->category_level = isset($request->category_level)?$request->category_level:1;
            $category->menu_item = $request->menu_item;
            $category->status = $request->status;
            $category->category_slug = $this->slugit($request->category_name);
            $category->created_by = Auth::guard('admin')->user()->id;
            $category->save();

            if ($request->hasFile('category_image')) {                
                $imagePath = $this->uploadCategoryAsset($category, $request);
                $category->category_image = $imagePath;
                $category->save();                
            }

            DB::commit();
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-success'=>"Category added successfully"]);
        } catch (\Exception $e) {
            
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-danger'=>"Failed to add category."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
		try {            	                                 	
            $title = 'View Category Detail';
            return view('admin.categories.show', compact('category', 'title'));	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        }         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('category_id', '!=', $category->category_id)->pluck('category_name','category_id');
        $categoryStatuses = GeneralStatus::toSelectArray();
        $title = 'Edit Category';
        return view('admin.categories.edit', compact('categories', 'categoryStatuses', 'title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {           
            $category->category_name = $request->category_name;
            $category->parent_category_id = isset($request->parent_category_id)?$request->parent_category_id:0;
            $category->category_description = $request->category_description;
            $category->category_level = isset($request->category_level)?$request->category_level:1;
            $category->category_slug = $this->slugit($request->category_name);
            $category->menu_item = $request->menu_item;
            $category->status = $request->status;
            $category->updated_by = Auth::guard('admin')->user()->id;
            $category->save();

            if ($request->hasFile('category_image')) {                
                $imagePath = $this->uploadCategoryAsset($category, $request);                
                $category->category_image = $imagePath;
                $category->save();                
            }

            DB::commit();
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-success'=>"Category updated successfully"]);
        } catch (\Exception $e) {
            
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-danger'=>"Failed to updating category."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if( $category->products->IsNotEmpty() ) {
            return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-danger'=>"Category associated to product."]);
        }
        if( $category->category_image ) {
            $this->removeAsset( $category->category_image );
        }        
        
        $category->delete();
        return redirect()->action('Admin\CategoryController@index')->withErrors(['alert-success'=>"Category deleted successfully."]);
    }

    /**
     * Get the file
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function removeAsset($image)
	{
        $directory = public_path('uploads/categories/');
        $thumbdirectory = public_path('uploads/categories/thumb/');
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
        $name = 'category_image';
        $directory = public_path('uploads/categories/');
		$thumbdirectory = public_path('uploads/categories/thumb/');
        
        $filename = $this->uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory);

		return $filename;		
	}
}

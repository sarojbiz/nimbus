<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Category;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use Illuminate\Validation\Rule;
use Image;
use File;


class CategoryController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::exclude(['created_by','created_at','updated_by','updated_at'])->get();
        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = [];
        $input = $request->all();
        $validator = Validator::make($input, [
            'category_id' => 'required|integer|unique:categories',
            'category_name' => 'required|unique:categories',
            'parent_category_id' => 'integer',
            'category_level' => 'integer'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $category = new Category;        
        $category = $this->getPostData($category, $input, $mode = 'save');  
        $category->category_slug = $this->slugit($input['category_name']);   
        if (isset($input['category_image']) && !empty($input['category_image'])) {
            $category_image = $this->uploadAsset($request, $name = 'category_image', $resize = array(750, null));
            $category->category_image = $category_image;
        }	              
        try{
            $result = $category->save(); 
            if(!$result){
                throw new Exception("Error in creating category.");
            }      
            $category_id = $category->category_id;           
            $category->where('category_id', $category_id)->update(['identifier' => md5($category_id.time())]); 
            $category = $category->where('category_id', $category->category_id)->exclude(['created_by','created_at','updated_by','updated_at'])->get();            
            $message = 'Category created successfully.';
            return $this->sendResponse($category, $message);
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($category, $message);          

        } catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($category, $message);
        }
    }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = [];     
		try {            	            
            $category= Category::exclude(['created_by','created_at','updated_by','updated_at'])->findOrFail($id);            	
            $message = 'Category detail.';	
            return $this->sendResponse($category, $message);	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($category, $message);          

        } catch (Exception $e) {

            $message = $e->getMessage();
            return $this->sendError($category, $message);

        }        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $category = [];
        $input = $request->except(['category_id']); 
        try{
            $category = Category::exclude(['created_by','created_at','updated_by','updated_at'])->findOrFail($id); 
            $old_category_image = $category->category_image;
            $validator = Validator::make($request->all(), [
                'category_name' => ['sometimes','required', Rule::unique('categories')->ignore($category->category_id, 'category_id')],
                'parent_category_id' => 'integer',
                'category_level' => 'integer'
            ]);
             
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());       
            }                  
            $category = $this->getPostData($category, $input, $mode = 'update'); 
            if(isset($input['category_name']) && !empty($input['category_name'])){
                $category->category_slug = $this->slugit($input['category_name']); 
            }            
            if (isset($input['category_image']) && !empty($input['category_image'])) {
                $category_image = $this->uploadAsset($request, $name = 'category_image', $resize = array(750, null), $old_category_image);
                $category->category_image = $category_image;
            }                     
            $result = $category->update();
            $category= Category::exclude(['created_by','created_at','updated_by','updated_at'])->findOrFail($id); 
            if(!$result){
                throw new Exception("Error in updating category.");   
            }
            $message = 'Category Updated successfully.';   
            return $this->sendResponse($category, $message); 
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($category, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($category, $message);

        } 		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $category = [];
        try {
            $category = Category::exclude(['created_by','created_at','updated_by','updated_at'])->findOrFail($id); 
            $result = $category->delete();
            if(!$result)
            {
                throw new Exception("error in deleting the category.");  
            }    
            $message = 'Category deleted successfully.';            
            return $this->sendResponse($category, $message);
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($category, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($category, $message);

        }
    }

    public function uploadAsset($request, $name, $resize, $old = '')
	{
        $remote = public_path('remote/');
        $remotefilename = $request[$name];
        if(!empty($name) && file_exists($remote.$remotefilename)){
            $remotefilename = $remote.$remotefilename;
        }else{
            return $remotefilename;
        }
        $directory = public_path('uploads/categories/');
        $thumbdirectory = public_path('uploads/categories/thumb/');
        
		if (!file_exists($directory)) {
			mkdir($directory, 0777, true);
		}
		if (!file_exists($thumbdirectory)) {
			mkdir($thumbdirectory, 0777, true);
		}
		$ext = pathinfo($remotefilename, PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $ext;
		$fileNameDir = $directory . '/' . $fileName;
        $upload = Image::make($remotefilename);
        
		$upload->resize($resize[0], $resize[1], function ($constraint) {
			$constraint->aspectRatio();
		});
		if($upload->save($fileNameDir, 100)){
            if(!empty($old) && file_exists($directory.$old)){
                $path1 = $directory . $old;
                File::delete($path1);
            }
        }

		$fileThumbNameDir = $thumbdirectory . '/' . $fileName;
		$upload->resize(250, 250, function ($constraint) {
			$constraint->aspectRatio();
		});
        if($upload->save($fileThumbNameDir, 100))
        {
            if(!empty($old) && file_exists($thumbdirectory.$old)){
                $path2 = $thumbdirectory . $old;
                File::delete($path2);
            }
        }

		return $fileName;		
	}		    
}
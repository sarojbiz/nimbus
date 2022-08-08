<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Category;
use Illuminate\Database\QueryException;
use Exception;

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
}
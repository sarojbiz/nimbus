<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Categories"; 
        $message = NULL;
        try {           
            $categories = category::where('parent_category_id', 0)->whereNotNull('category_slug')->orderBy('category_level', 'ASC')->with('childrenRecursive')->get();
            $allCategories = category::whereNotNull('category_slug')->orderBy('category_level', 'ASC')->with('childrenRecursive')->get();	 
            if($categories->isEmpty()){
                throw new Exception("No active categories found.");   
            }   
            
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  

        } catch (Exception $e) {

            $message = $e->getMessage();

        }   
        return view('categories.index', compact('title', 'message'))
                    ->withCategories($categories)
                    ->withAllCategories($allCategories);	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $category_slug
     * @return \Illuminate\Http\Response
     */
    public function show($category_slug)
    { 
        $title = "All Categories";   
        $products = NULL;
        $message = NULL;
		try {           
            $categories = category::where('parent_category_id', 0)->whereNotNull('category_slug')->orderBy('category_level', 'ASC')->with('childrenRecursive')->get();	  
            $category = Category::exclude(['created_by','created_at','updated_by','updated_at'])->where('category_slug', $category_slug)->firstOrFail(); 
            $title = $category->category_name;
            $products = Product::where('category_code', $category->category_id)->where('product_status', 1)->get(); 
            if($products->isEmpty()){
                $suggested = TRUE;
                $products = Product::where('product_status', 1)->get();
                throw new Exception("No products found for this category. Please browse our suggested Products.");   
            }   
            
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  

        } catch (Exception $e) {

            $message = $e->getMessage();

        }   
        return view('categories.show', compact('title', 'message'))
                    ->withProducts($products)
                    ->withCategories($categories);	  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Product Search';
        $categories = category::select('category_slug','category_name')->where('parent_category_id', 0)->whereNotNull('category_slug')->orderBy('category_level', 'ASC')->get();
        if($request->has('term')){
            $query = $request->get('term');   
        }
        
        $products = Product::select('pdt_id', 'mcode','pdt_name','pdt_short_description','regular_price','pdt_code','feature_image','slug')->where(function($q) use($request){
            if($request->has('term')){
                $q->where('pdt_name', $request->get('term'));   
            }
        });
        if($request->has('term')){
            $product = $products->first();
            if(!$product){
                $products = Product::select('pdt_id', 'mcode','pdt_name','pdt_short_description','regular_price','pdt_code','feature_image','slug')->where('pdt_name','ilike','%'.$request->get('term').'%')->get();
            }else{
                return redirect(route('product', $product->slug));
            }
        }else{
            $products = $products->get();   
        }
        return view('search.index', compact('title'))
               ->withproducts($products)
               ->withcategories($categories);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

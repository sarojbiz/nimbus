<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $product = Product::where('products.slug', $slug)->with(['sizes', 'colors'])->first();
        
        if(is_null($product)){
            return abort(404, 'Product not found.');
        }        
        $title = $product->pdt_name;        
        $related = Product::where(array('product_status'=> 1))->inRandomOrder()->limit(6)->get();
        return view('products.index', compact('title'))
                ->withproduct($product)
                ->withrelated($related);
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

    /**
     * Auto Suggest the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        if(!$request->ajax()){
			abort(404);
        }
        $response = [];
        $query = $request->get('query'); 
        $products = Product::select('pdt_name')->where('pdt_name','ilike','%'.$query.'%')->get();
        if(is_object($products) && !empty($products)){
            foreach($products as $product)
            {
                $response[] = $product->pdt_name;
            }
        }
        return response()->json($response);
    }

    
}

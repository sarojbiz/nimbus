<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\GeneralStatus;
use App\Product;
use App\Http\Resources\ProductResource;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     * this is default product search.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|min:3'
        ]);

        $products = Product::where('pdt_name', 'ilike', '%'.$request->keyword.'%')
                    ->where('product_status', GeneralStatus::Enabled) 
                    ->orderBy('pdt_name', 'ASC')                                            
                    ->get();

        return ProductResource::collection($products);   
    }

    /**
     * Display a listing of the resource.
     * product search using product name.
     *
     * @return \Illuminate\Http\Response
     */
    public function productSearch(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|min:3'
        ]);

        $products = Product::where('pdt_name', 'ilike', '%'.$request->keyword.'%')
                    ->where('product_status', GeneralStatus::Enabled) 
                    ->orderBy('pdt_name', 'ASC')                                            
                    ->get();

        return ProductResource::collection($products);   
    }    
}
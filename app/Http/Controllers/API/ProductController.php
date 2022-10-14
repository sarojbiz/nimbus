<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        //$products = Product::where('product_status', 1)->orderBy('pdt_id', 'ASC')->get();        
        $products = Product::where('product_status', 1)->orderBy('pdt_id', 'ASC')->paginate(10);        
        return ProductResource::collection($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $mcode
     * @return \Illuminate\Http\Response
     */
    public function show($mcode)
    {
        $product = [];     
		try {            	            
            $product= Product::exclude(['created_by','created_at','updated_by','updated_at'])->where('mcode',$mcode)->firstOrFail();            	            
            return new ProductResource($product);	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return response()->json(['message' => $message], 406);          

        } catch (Exception $e) {

            $message = 'Error in fetching product data.';  
            return response()->json(['message' => $message], 406);

        }        
    }
}
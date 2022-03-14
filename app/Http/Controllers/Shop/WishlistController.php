<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Cart;
use App\Product;
use Exception;

class WishlistController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "My Wish List";
        $mcodes = app('wishlist')->getContent()->pluck('id')->all();
        $products = Product::whereIn('mcode', $mcodes)->get();
        return view('ecommerce.wishlist', compact('title','products'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if(!$request->ajax()){
			abort(404);
        }        
        $mcode = Crypt::decryptString($request->productId);	
        $mcodes = app('wishlist')->getContent()->pluck('id')->all();        
        try{
            if(in_array($mcode, $mcodes)){
                throw new Exception("Product already added to Wishlist.");
            }
            $product = Product::select('pdt_id','mcode','pdt_name','pdt_short_description','pdt_code','feature_image','slug', 'has_size_color')->where('mcode', $mcode)->first();
            if(!$product){
                throw new Exception("Error Invalid product added to cart.");
            }

            //we add pdt_id in request to use while checking for inventory prices
            $request->request->add(['pdt_id' => $product->pdt_id]);
            $inventoryProduct = $product::getInventory($request);

            $wish_list = app('wishlist');
            $id = $product->mcode;
            $name = $product->pdt_name;
            $price = $inventoryProduct->sales_price ? round($inventoryProduct->sales_price, 2) : round($inventoryProduct->regular_price, 2);
            $attributes = array(
                'regular_price' => round($inventoryProduct->regular_price, 2),
                'sales_price' => round($inventoryProduct->sales_price, 2),
                'html_format_price' => ( $inventoryProduct->sales_price ) ? '<span class="old amount">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span> <span class="amount">Rs. '.number_format($inventoryProduct->sales_price, 2).'</span>' : '<span class="amount">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span>',
            );

            $qty = 1;
            $result = $wish_list->add($id, $name, $price, $qty, $attributes);
            
            if(!$result){
                throw new Exception("Unable to add to cart. Please try again.");
            }
            $message = $product->pdt_name. ' added successfully to wishlist.';
            $return = $this->prepare_return($product);
            $return['totalquantity'] = $wish_list->getTotalQuantity();
            return $this->sendResponse($return, $message);
        }
        catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($message);
        }
    }

    public function prepare_return($product)
    {
        $return = [];
        $return['cartid'] = $product->mcode;
        $return['item_url'] = route('product', $product->slug);
        $return['feature_image'] = $product->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $product->feature_image]) : "";
        $return['name'] = $product->pdt_name;
        return $return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        if(!$request->ajax()){
			abort(404);
        }        
        $wishid = $request->wishid;	
        try{
            $wish_list = app('wishlist');
            $remove = $wish_list->remove($wishid);
            if(!$remove){
                throw new Exception("Unable to remove product from wishlist. Please try again.");
            }
            $message = 'Product removed successfully from wishlist.';    
            $wish_list = app('wishlist');
            $return['totalquantity'] = $wish_list->getTotalQuantity();     
            return $this->sendResponse($return, $message);
        }
        catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($message);
        }
    }
}

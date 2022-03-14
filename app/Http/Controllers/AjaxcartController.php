<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Cart;
use App\Product;
use Exception;

class AjaxcartController extends ResponseController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if(!$request->ajax()){
			abort(404);
        }        
        $mcode = Crypt::decryptString($request->productId);	
        try{
            $product = Product::select('pdt_id','mcode','pdt_name','pdt_short_description','pdt_code','feature_image','slug')->where('mcode', $mcode)->first();
            if(!$product){
                throw new Exception("Error Invalid product added to cart.");
            }

            //we add pdt_id in request to use while checking for inventory prices
            $request->request->add(['pdt_id' => $product->pdt_id]);
            $inventoryProduct = $product::getInventory($request);

            $item = array(
                'id' => uniqid(), // inique row ID
                'pdt_id' => $product->pdt_id, 
                'name' => $product->pdt_name,
                'price' => $inventoryProduct->sales_price ? round($inventoryProduct->sales_price, 2) : round($inventoryProduct->regular_price, 2),               
                'quantity' => 1,
                'attributes' => array(
                    'regular_price' => $inventoryProduct->regular_price,
                    'sales_price' => $inventoryProduct->sales_price,
                    'html_format_price' => ( $inventoryProduct->sales_price ) ? '<span class="old amount">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span> <span class="amount">Rs. '.number_format($inventoryProduct->sales_price, 2).'</span>' : '<span class="amount">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span>',
                ),
                'associatedModel' => $product
            ); 
            $result = Cart::add($item);
            if(!$result){
                throw new Exception("Unable to add to cart. Please try again.");
            }
            $message = $product->pdt_name. ' added successfully to cart.';
            $return = $this->prepare_return($item);
            return $this->sendResponse($return, $message);
        }
        catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($message);
        }
    }

    public function prepare_return($item)
    {
        $return = [];
        $return['cartid'] = $item['id'];
        $return['item_url'] = route('product', $item['associatedModel']->slug);
        $return['feature_image'] = $item['associatedModel']->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $item['associatedModel']->feature_image]) : "";
        $return['name'] = $item['name'];
        $return['quantity'] = $item['quantity'];
        $return['price'] = $item['price'];
        $return['regular_price'] = $item['attributes']['regular_price'];
        $return['sales_price'] = $item['attributes']['sales_price'];
        $return['html_format_price'] = $item['attributes']['html_format_price'];
        $return['total'] = Cart::getTotal();
        $return['totalquantity'] = Cart::getTotalQuantity();
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
        $cartId = $request->cartId;	
        try{
            $remove = Cart::remove($cartId);;
            if(!$remove){
                throw new Exception("Unable to remove product from cart. Please try again.");
            }
            $message = 'Product removed successfully from cart.';    
            $return = [];
            $return['total'] = Cart::getTotal();
            $return['totalquantity'] = Cart::getTotalQuantity();        
            return $this->sendResponse($return, $message);
        }
        catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($message);
        }
    }
}

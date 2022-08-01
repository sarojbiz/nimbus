<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use Illuminate\Support\Facades\Crypt;
use App\Product;
use App\Size;
use App\Color;
use Cart;

class CartController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Cart::getContent();
        if(is_object($items) && !empty($items))
        {
            foreach($items as $item)
            {
                $item->put('totalprice', Cart::get($item->id)->getPriceSum());
            }
        }
        $total = Cart::getTotal();
        if($total == 0){
            return response()->json([
                'message' => 'Your shopping Cart is empty.',
                'errors' => [
                    "cart" => 'empty cart',
                ]
            ], 422);
        }else{
            return view('cart', compact('title'))
                    ->withitems($items)
                    ->withtotal($total);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $mcode = '';
        if($request->has('productId'))
            $mcode = Crypt::decryptString($request->productId);	

        try{
            $product = Product::select('pdt_id','mcode','pdt_name','pdt_short_description','pdt_code','feature_image','slug', 'has_size_color')->where('mcode', $mcode)->first();
            if(!$product){
                throw new Exception("Error Invalid product added to cart.");
            }

            //we add pdt_id in request to use while checking for inventory prices
            $request->request->add(['pdt_id' => $product->pdt_id]);
            $inventoryProduct = $product::getInventory($request);
            if(!$inventoryProduct){
                throw new Exception("selected product is not available.");
            }
            
            $item = array(
                'id' => uniqid(), // inique row ID
                'pdt_id' => $product->pdt_id, 
                'name' => $product->pdt_name,
                'price' => $inventoryProduct->sales_price ? round($inventoryProduct->sales_price, 2) : round($inventoryProduct->regular_price, 2),                
                'quantity' => $request->get('quantity')?$request->get('quantity'):1,
                'attributes' => array(
                    'size_id' => $request->get('size'),
                    'size_name' =>  Size::where('id', $request->get('size'))->pluck('name')->first(),
                    'color_id' => $request->get('color'),
                    'color_name' => Color::where('id', $request->get('color'))->pluck('name')->first(),
                    'regular_price' => $product->regular_price,
                    'sales_price' => $product->sales_price,
                    'html_format_price' => ( $inventoryProduct->sales_price ) ? '<span class="old amount">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span> <span class="amount">Rs. '.number_format($inventoryProduct->sales_price, 2).'</span>' : '<span class="amount">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span>',
                ),
                'associatedModel' => $product
            ); 

            $result = Cart::add($item);
            if(!$result){
                throw new Exception("Unable to add to cart. Please try again.");
            }
            $message = $product->pdt_name. ' added successfully to cart.';
        }
        catch (Exception $e) {
            $message = $e->getMessage();
            
        }
        return redirect(route('product', $product->slug))->withErrors(['alert-success'=>$message]);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $items = $request->quant;
        if(is_array($items) && !empty($items))
        {
            foreach($items as $key=>$val)
            {
                Cart::update($key, array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $val                        
                    ),
                  ));
            }
        }
        return redirect(route('cart'))->withSuccess(['alert-success'=>'Cart updated successfully.']);       
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

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\OrderProduct;
use Auth;
use App\Enums\GeneralStatus;
use App\Enums\OrderStatus;
use App\Http\Requests\API\CheckoutRequest;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    private $baseOrder = 572098;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(CheckoutRequest $request)
    {
        $order = new Order();

        $order->s_first_name = $request->get('shipping_fname');
        $order->s_last_name = $request->get('shipping_lname');
        $order->s_email = $request->get('shipping_email');
        $order->s_street_address = $request->get('shipping_street_address');
        $order->s_city = $request->get('shipping_city');
        $order->s_postcode = $request->get('shipping_postal_code');
        $order->s_state = $request->get('shipping_state');
        $order->s_phone = $request->get('shipping_phone');
        $order->s_country = $request->get('shipping_country');
        
        $order->b_first_name = $request->get('same_billing_shipping') ? $request->get('shipping_fname') : $request->get('billing_fname');
        $order->b_last_name = $request->get('same_billing_shipping') ? $request->get('shipping_lname') : $request->get('billing_lname');
        $order->b_email = $request->get('same_billing_shipping') ? $request->get('shipping_email') : $request->get('billing_email');
        $order->b_street_address = $request->get('same_billing_shipping') ? $request->get('shipping_street_address') : $request->get('billing_street_address');
        $order->b_city = $request->get('same_billing_shipping') ? $request->get('shipping_city') : $request->get('billing_city');
        $order->b_postcode = $request->get('same_billing_shipping') ? $request->get('shipping_postal_code') : $request->get('billing_postal_code');
        $order->b_state = $request->get('same_billing_shipping') ? $request->get('shipping_state') : $request->get('billing_state');
        $order->b_phone = $request->get('same_billing_shipping') ? $request->get('shipping_phone') : $request->get('billing_phone');
        $order->b_country = $request->get('same_billing_shipping') ? $request->get('shipping_country') : $request->get('s_first_name');
        
        $order->ip = $request->ip();
        $order->user_agent = $request->server('HTTP_USER_AGENT');
        $order->status = GeneralStatus::Enabled;
        $order->order_status_id = OrderStatus::Pending;
        $order->total = 100.00;
        $order->user_id = optional(Auth::user())->id;
        $order->save();
        
        //update order number
        $order_no = intval($this->baseOrder + $order->id);
        $order->order_no = 'SO-'.$order_no;
        $order->save();

        //now save order products
        $carts = json_decode($request->carts, true);
        
        if( is_array($carts) && !empty($carts) ) {
            foreach( $carts as $cart) {  
                //get product details from cart product id
                $product = Product::where('products.pdt_id', $cart['pdt_id'])->first();                
                if( $product ) {
                    $request->request->add(['pdt_id' => $product->pdt_id]);
                    $inventoryProduct = $product::getInventory($request);
                    
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $product->pdt_id;
                    $orderProduct->inventory_product_id = $inventoryProduct->id;
                    $orderProduct->product_name = $product->pdt_name;
                    $orderProduct->color_id = $product->has_size_color ? $cart['color'] : NULL;
                    $orderProduct->color_name = $product->has_size_color ? $cart['color'] : NULL;
                    $orderProduct->size_name = $product->has_size_color ? $cart['size'] : NULL;
                    $orderProduct->size_id = $product->has_size_color ? $cart['size'] : NULL;
                    $orderProduct->price =  $inventoryProduct->actual_price;                    
                    $orderProduct->quantity = $cart['quantity'];
                    $orderProduct->subtotal = round(($inventoryProduct->actual_price * $cart['quantity']), 2);
                    $orderProduct->tax = 0.00;
                    $orderProduct->total = round(($inventoryProduct->actual_price * $cart['quantity']), 2);
                    $orderProduct->save();
                }
            }
        }
        return response()->json(['message' => 'Checkout Successful.'], 200);
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

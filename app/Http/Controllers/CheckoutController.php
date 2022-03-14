<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Auth;
use App\Product;
use App\Order;
use App\OrderProduct;
use App\Enums\OrderStatus;
use App\Enums\GeneralStatus;
use App\Enums\ProvienceType;
use App\Enums\Countries;

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
       $title = 'Checkout';
       $proviences = ProvienceType::toSelectArray();
       $countries = Countries::toSelectArray();
       $subtotal = Cart::getSubTotal();       
       $gettotal = Cart::getTotal();       
       if($gettotal == 0){
            $message = "Unable to checkout, Cart is empty.";
            return view('ecommerce.checkout.error', compact('title','message'));    
       }else{
            return view('ecommerce.checkout.index', compact('title','subtotal','gettotal', 'proviences', 'countries'));    
       }
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
        $order->total = Cart::getTotal();
        $order->user_id = optional(Auth::user())->id;
        $order->save();
        
        //update order number
        $order_no = intval($this->baseOrder + $order->id);
        $order->order_no = 'MC-'.$order_no;
        $order->save();

        //now save order products
        $cartCollection = Cart::getContent();
        $cartProducts = $cartCollection->toArray();
        
        if( is_array($cartProducts) && !empty($cartProducts) ) {
            foreach( $cartProducts as $cartProduct) {  
                //get product details from cart product id
                $product = Product::where('products.pdt_id', $cartProduct['associatedModel']['pdt_id'])->first();                
                if( $product ) {
                    $request->request->add(['pdt_id' => $product->pdt_id]);
                    $inventoryProduct = $product::getInventory($request);
                    
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $product->pdt_id;
                    $orderProduct->inventory_product_id = $inventoryProduct->id;
                    $orderProduct->product_name = $product->pdt_name;
                    $orderProduct->color_id = $product->has_size_color ? $cartProduct['attributes']['color_id'] : NULL;
                    $orderProduct->color_name = $product->has_size_color ? $cartProduct['attributes']['color_name'] : NULL;
                    $orderProduct->size_name = $product->has_size_color ? $cartProduct['attributes']['size_name'] : NULL;
                    $orderProduct->size_id = $product->has_size_color ? $cartProduct['attributes']['size_id'] : NULL;
                    $orderProduct->price =  $inventoryProduct->actual_price;                    
                    $orderProduct->quantity = $cartProduct['quantity'];
                    $orderProduct->subtotal = round(($inventoryProduct->actual_price * $cartProduct['quantity']), 2);
                    $orderProduct->tax = 0.00;
                    $orderProduct->total = round(($inventoryProduct->actual_price * $cartProduct['quantity']), 2);
                    $orderProduct->save();
                }
            }
        }
        return redirect(route('checkout.thankyou'));

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
    public function thankyou()
    {
        Cart::clear();
        $title = "Thank You";
        $message = "Your order have been placed successfully. We will contact you soon.";
        return view('ecommerce.checkout.thankyou', compact('title','message'));   
    }
}

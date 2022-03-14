<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use DB;
use Carbon\Carbon;
use App\Enums\OrderStatus;
use App\Enums\GeneralStatus;
use App\Enums\ProvienceType;
use App\Enums\Countries;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get();
        $title = 'Orders Listing';
        return view('admin.orders.index', compact('orders', 'title'));
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
    public function show(Order $order)
    {
        try {    
            $proviences = ProvienceType::toSelectArray();
            $countries = Countries::toSelectArray();
            $shippingStatues = OrderStatus::toSelectArray();  
            $statuses = GeneralStatus::toSelectArray();        	                                 	
            $title = 'View Order Detail';
            return view('admin.orders.show', compact('order', 'shippingStatues', 'statuses', 'proviences', 'countries', 'title'));	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\OrderController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\OrderController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        }   
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
    public function update(Request $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $order->order_status_id = $request->get('order_status_id');
            $order->status = $request->get('status');
            $order->save();

            DB::commit();
            return redirect()->action('Admin\OrderController@index')->withErrors(['alert-success'=>"Order #{$order->order_no} updated successfully."]);
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->action('Admin\OrderController@index')->withErrors(['alert-danger'=>"Error in updating Order #{$order->order_no}."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->orderProducts()->delete();
        $order->delete();
        return redirect()->action('Admin\OrderController@index')->withErrors(['alert-success'=>"Order deleted successfully."]);
    }
}

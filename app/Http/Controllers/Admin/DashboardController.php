<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Enums\OrderStatus;
use App\Enums\GeneralStatus;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('order_status_id', OrderStatus::Pending)->where('status', GeneralStatus::Enabled)->orderBy('id', 'DESC')->limit(10)->get();
        $orderAmounts = Order::select(DB::raw("EXTRACT (YEAR FROM created_at)::INTEGER AS year, EXTRACT (MONTH FROM created_at)::INTEGER AS month, SUM(total) AS grandtotal"))
                        ->where('order_status_id', OrderStatus::Completed)
                        ->where('status', GeneralStatus::Enabled)
                        ->where(DB::raw("EXTRACT (YEAR FROM created_at)"), '=', DATE('Y'))
                        ->groupBy('year','month')
                        ->orderBy('month', 'ASC')
                        ->get();
        
                        
        $graphPricing = [];
        if($orderAmounts->IsNotEmpty()){
            foreach(range(1, 12) as $month){ 
                $graphPricing[$month] = $orderAmounts->where('month', $month)->pluck('grandtotal')->first();  
            }
        }
        return view('admin.dashboard', compact('orders', 'graphPricing'));
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

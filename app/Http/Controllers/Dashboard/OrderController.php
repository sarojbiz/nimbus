<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Order;
use App\Enums\GeneralStatus;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'My Orders';
        $orders = Order::where('user_id', optional(Auth::user())->id)->where('status', GeneralStatus::Enabled)->orderBy('id', 'DESC')->limit(10)->get();
        return view('dashboard.orders', compact('title', 'orders'));
    }
}

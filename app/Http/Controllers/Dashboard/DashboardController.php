<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Order;
use App\Enums\GeneralStatus;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Dashboard';
        $orders = Order::where('user_id', optional(Auth::user())->id)->where('status', GeneralStatus::Enabled)->orderBy('id', 'DESC')->limit(10)->get();
        return view('dashboard.index', compact('title', 'orders'));
    }
}

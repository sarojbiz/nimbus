@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css" />
<style>
.btn.btn-sm{
    padding: 5px 10px; 
    border-radius: 5px;
}
</style>
@endsection
@section('content')
<!--START my_account -->
<main id="my_account" class="my_account section shop">
    <div class="wrap">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                @include('dashboard.sidebar')
            </div>
            <!--.account-sidebar wrapper ends-->

            <div class="col-lg-9 col-md-8 col-12 account_entry">
                <div class="account_title">
                    <h1>My Orders</h1>
                </div>
                <div class="row account_orders acc_row">
                    <div class="col-lg-12">
                        <div class="accont_block">
                            <div class="accblock_title">
                                <h4>My Order List : </h4>
                                <h6>Member ID : {{ Auth::user()->member_id }}</h6>
                                @include('errors.errors')
                            </div>
                            <div class="accblock_body">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Amount</th>
                                <th>Shipping</th>
                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>{{$order->order_no}}</td>                                
                                    <td>{{Carbon::parse($order->created_at)->format('Y-m-d g:i A')}}</td>
                                    <td>{{'Rs '. round($order->total, 2)}}</td>
                                    <td>{{OrderStatus::fromValue($order->order_status_id)->description}}</td>
                                    <td>{{GeneralStatus::fromValue($order->status)->description}}</td>
                                    <th>
                                        <a class="btn btn-sm" href="#" title="View Order">Detail</a>
                                    </th>
                                </tr>
                                @empty
                                <tr><td colspan="9"> No New Order Placed Yet. </td></tr>
                                @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <!--.accont_block ends-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END my_account -->

@endsection
@section('scripts')

@endsection
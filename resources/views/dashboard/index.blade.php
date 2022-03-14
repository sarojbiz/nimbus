@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<style>
.btn.btn-sm{
    padding: 5px 10px; 
    border-radius: 5px;
}
</style>
<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css" />
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
                        <h1>Dashboard</h1>
                    </div>
                    <div class="row account_profile acc_row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="accont_block">
                                <div class="accblock_title">
                                    <span class="ab_title">Personal Profile</span>
                                </div>
                                <div class="accblock_body">
                                    <div class="profile_info">
                                        <div class="profile_item">{{ ucfirst(Auth::user()->full_name) }}</div>
                                        <div class="profile_item">{{ Auth::user()->email }}</div>
                                        <div class="profile_item">Registered At : {{ Auth::user()->registered_date }}</div>
                                    </div>
                                    <div class="profile_links">
                                        <a href="{{action('Dashboard\ProfileController@index')}}" title="View Profile">View Full Profile</a>
                                    </div>
                                </div>

                            </div>
                            <!--.accont_block ends-->

                        </div>

                        <div class="col-lg-8 col-md-6 col-12">
                            <div class="accont_block personal_info">
                                <div class="accblock_title">
                                    <span class="ab_title">Address Book</span>
                                </div>
                                <div class="accblock_body">
                                    <div class="acc_subtitle">
                                        SHIPPING ADDRESS
                                    </div>
                                    <div class="acc_info">
                                        <div class="acc_item">Bagmati - Lalitpur Inside Ring Road - Ward 15 - Satdobato
                                            Area</div>
                                    </div>
                                    <div class="profile_links">
                                        <a href="{{action('Dashboard\AddressbookController@index')}}" title="View Address Book">View Address Book</a>
                                    </div>
                                </div>

                            </div>
                            <!--.accont_block ends-->
                        </div>

                    </div>
                    <div class="row account_orders acc_row">
                        <div class="col-lg-12">

                            <div class="accont_block">
                                <div class="accblock_title">
                                    <h4>Recent Orders</h4>
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
        </div>
    </main>
    <!-- END my_account -->
 



@endsection
@section('scripts')

@endsection
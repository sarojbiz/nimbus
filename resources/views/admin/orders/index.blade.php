@extends('admin.master')
@section('title', $title)
@section('stylesheets')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Orders Listing</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orders</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>                
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                        <th>Order No</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amt</th>
                        <th width="10%">Shipping</th>
                        <th>Order Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_object($orders) && !empty($orders))
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->order_no}}</td>                                
                                <td>{{Carbon::parse($order->created_at)->format('Y-m-d g:i A')}}</td>
                                <td>{{$order->b_first_name . ' ' . $order->b_last_name}}</td>
                                <td>{{$order->b_email}}</td>
                                <td>{{$order->b_phone}}</td>
                                <td>{{'Rs '. round($order->total, 2)}}</td>
                                <td>{{OrderStatus::fromValue($order->order_status_id)->description}}</td>
                                <td>{{GeneralStatus::fromValue($order->status)->description}}</td>
                                <th>
                                    <a href="{{ action('Admin\OrderController@show', $order->id) }}" title="View Order">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\OrderController@destroy', $order->id) }}" title="Delete Order" onclick="return confirm('Are you sure you want to delete?');">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </a>
                                </th>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
@section('scripts')
<!-- Page level plugins -->
<script src="{{asset('/backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script>
    jQuery(function($){
      $('#dataTable').DataTable({
          "order": [[1, "DESC"]]
      });
    });
  </script>
@endsection
@extends('admin.master')
@section('title', $title)
@section('stylesheets')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
#dataTableHover tr td span.old {
    text-decoration: line-through;
    font-size: 12px;
    display: inline-block;
    width: 100%;
}
</style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Product Listing</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Products</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
                <div>
                    <a href="{{ action('Admin\ProductController@import') }}" title="import all products" class="btn btn-primary mb-1 mr-1">Import</a>
                   <a href="{{ action('Admin\ProductController@export') }}" title="export all products" class="btn btn-primary mb-1 mr-1">Export</a>
                    <a href="{{ action('Admin\ProductController@create') }}" title="Add new product" class="btn btn-primary mb-1">Add New</a>
                </div>    
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                        <th>MCode</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Product Type</th>
                        <th>Brand</th>
                        <th>Sales Product</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_object($products) && !empty($products))
                            @foreach($products as $product)
                            <tr>
                                <td>{{$product->mcode}}</td>
                                <td>{{$product->pdt_name}}</td>
                                <td>@if($product->category_code > 0){{$product->parent->category_name}}@endif</td>
                                <td>{{ App\Enums\ProductType::fromValue($product->has_size_color)->description }}</td>
                                <td>{{ $product->pdt_brand ? $product->brand->name : '' }}</td>                                
                                <td>{{$product->is_sale_product ? 'Yes' : 'No'}}</td>
                                <td>@if($product->created_by > 0){{ucwords($product->createdBy->first_name.' '.$product->createdBy->last_name)}}@endif</td>
                                <td>@if($product->updated_by > 0){{ucwords($product->createdBy->first_name.' '.$product->createdBy->last_name)}}@endif</td>
                                <th>
                                    <a href="{{ action('Admin\ProductController@edit', $product->pdt_id) }}" title="Edit Product">
                                        <i class="fas fa-pen fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\ProductController@destroy', $product->pdt_id) }}" title="Delete Product" onclick="return confirm('Are you sure you want to delete?');">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\ProductController@show', $product->pdt_id) }}" title="View Product">
                                        <i class="fas fa-eye fa-fw"></i>
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
      $('#dataTableHover').DataTable({
        "order": [[ 0, "desc" ]]
      });
    });
  </script>
@endsection
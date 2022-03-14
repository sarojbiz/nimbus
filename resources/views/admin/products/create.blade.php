@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
    </ol>
</div>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Product Details: </h6>
        </div>
        <div class="card-body">
            {!! Form::model($product, ['action' => 'Admin\ProductController@index', 'files' => true]) !!}
            @include('admin.products.form')
            {!! Form::close() !!}
        </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
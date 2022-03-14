@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Product Detail</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Product</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Product : {{$product->pdt_name}}</h6>
        </div>
        <div class="card-body">
            <form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label(null, 'Mcode')!!}
                        {!! Form::label(null, $product->mcode, ['class' => 'form-control']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::label(null, 'Product Name')!!}
                        {!! Form::label(null, $product->pdt_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label(null, 'Category')!!}
                        {!! Form::label(null, $product->category_code ? $product->parent->category_name : '', ['class' => 'form-control']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::label(null, 'Brand')!!}
                        {!! Form::label(null, $product->pdt_brand ? $product->brand->name : '', ['class' => 'form-control']) !!}                         
                    </div>
                    <div class="form-group">
                    <label for="pdt_brand">Regular Price</label>    
                        <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">Rs</span>
                        </div>
                        <input type="text" class="form-control" value="{{$product->regular_price}}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="pdt_brand">Sales Price</label>    
                        <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">Rs</span>
                        </div>
                        <input type="text" class="form-control" value="{{$product->sales_price}}" readonly="readonly">
                        </div>
                    </div>                        
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label(null, 'Code')!!}
                        {!! Form::label(null, $product->pdt_code, ['class' => 'form-control']) !!}                         
                    </div> 
                    <div class="form-group">
                        {!! Form::label(null, 'SKU')!!}
                        {!! Form::label(null, $product->inventory_sku, ['class' => 'form-control']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::label(null, 'Sales Product')!!}
                        {!! Form::label(null, $product->is_sale_product ? 'Yes' : 'No', ['class' => 'form-control']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::label(null, 'Sales Product')!!}
                        {!! Form::label(null, GeneralStatus::fromValue($product->product_status)->description, ['class' => 'form-control']) !!}                        
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="pdt_short_description">Short Description</label>
                <textarea name="pdt_short_description" class="form-control" id="pdt_short_description" rows="3">{!! $product->pdt_short_description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="pdt_long_description">Brief Description</label>
                <textarea name="pdt_long_description" class="form-control" id="pdt_long_description" rows="3">{!! $product->pdt_long_description !!}</textarea>
            </div>             
            <div class="form-group">
                <label for="feature_image">Product Image</label>
                <img class="form-control" src="{{ action('Admin\UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $product->feature_image ? $product->feature_image : 'no-image.png']) }}" title="{{$product->feature_image}}" style="width:200px; height:auto;" />
            </div>
            <a href="{{ action('Admin\ProductController@index') }}" class="btn btn-primary">Back</a>
            </form>
        </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
@section('scripts')
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>
    CKEDITOR.replace( 'pdt_short_description', {readOnly:true} );
    CKEDITOR.replace( 'pdt_long_description', {readOnly:true} );
</script>
@endsection   
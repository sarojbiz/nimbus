
@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!--START Breadcrumbs -->
<div class="breadcrumbs">
        <div class="wrap">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home <ion-icon name="arrow-forward-outline"></ion-icon></a></li>
                            <li class="active"><a href="#">{{$product->pdt_name}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Breadcrumbs -->
    <main id="single_product" class="single_product section">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="product_gallery">                        
                            @if(!empty($product->feature_image) && file_exists('uploads/products/'.$product->feature_image))
                                <div class="show" href="{{URL::asset('uploads/products/'.$product->feature_image)}}">
                                    <img class="default-img" src="{{URL::asset('uploads/products/'.$product->feature_image)}}" alt="{{$product->pdt_name}}" id="show-img">
                                </div>    
                            @endif                        
                        <!--.show ends-->                        
                    </div>
                    <!--.product_gallery ends-->
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 product_details">
                    @include('errors.errors')
                    <form name="add_single_product" id="add_single_product" action="{{route('add_single_product')}}" method="post">
                        <div class="quickview-content">
                            <h1>{{$product->pdt_name}}</h1>
                            <input type="hidden" name="productId" value="{{Crypt::encryptString($product->mcode)}}" />
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        <ion-icon class="yellow" name="star"></ion-icon>
                                        <ion-icon class="yellow" name="star"></ion-icon>
                                        <ion-icon class="yellow" name="star"></ion-icon>
                                        <ion-icon class="yellow" name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon>
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#reviewModal"> (1 customer review) </a>
                                </div>
                                <div class="quickview-stock">
                                    <span>
                                        <ion-icon name="checkmark-circle"></ion-icon> in stock
                                    </span>
                                </div>
                            </div>
                            @if( $product->simple_product )                                
                                @if( optional($product->inventorySimpleProduct)->sales_price )
                                    <h3 class="product_price">Rs. {{number_format(optional($product->inventorySimpleProduct)->sales_price, 2)}}</h3>
                                    <p class="old_price">Rs. {{number_format(optional($product->inventorySimpleProduct)->regular_price, 2)}}</p>
                                @else
                                    <h3>Rs. {{number_format(optional($product->inventorySimpleProduct)->regular_price, 2)}}</h3>
                                @endif
                            @endif

                            @if(isset($product->brand))
                                <p><strong>Brand : {{$product->brand->name}}</strong></p>
                            @endif
                            
                            @if( $product->sizes->IsNotEmpty() || $product->colors->IsNotEmpty() )
                            <div class="size">
                                <div class="row"> 
                                    @if( $product->sizes->IsNotEmpty() )                                 
                                    <div class="col-lg-6 col-12">
                                        <h5 class="title">Size *</h5>
                                        <select name="size" required="required">
                                            <option value="">Please Select Size</option>
                                            @foreach ( $product->sizes as $attribute )
                                            <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    @if( $product->colors->IsNotEmpty() )                                  
                                    <div class="col-lg-6 col-12">
                                        <h5 class="title">Color *</h5>
                                        <select name="color" required="required">
                                            <option value="">Please Select Color</option>
                                            @foreach ( $product->colors as $attribute )
                                            <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                </div>
                            </div>    
                            @endif 

                            <div class="quantity">
                                <!-- Input Order -->
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="minus"
                                            data-field="quantity">
                                            <ion-icon class="ti-minus" name="remove-outline"></ion-icon>
                                        </button>
                                    </div>
                                    <input type="text" name="quantity" class="input-number" data-min="1" data-max="100" value="1">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                            data-field="quantity">
                                            <ion-icon class="ti-plus" name="add-outline"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <!--/ End Input Order -->
                            </div>
                            <div class="add-to-cart">
                                <input type="submit" class="btn" value="Add to cart" />
                                <a title="Add to Wishlist" href="#" class="btn min addToWishlist" data-productid="{{Crypt::encryptString($product->mcode)}}">
                                    <ion-icon name="heart-outline"></ion-icon>
                                </a>
                            </div>                            
                        </div>
                        {{ csrf_field() }}
                    </form>    
                    <!--.quickview ends-->

                </div>
            </div>
        </div>
    </main>

    @include('products.product_review_modal')

    @include('products.product_tabs')

    @include('products.related_products')

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<!-- zoom-image js-->
<script src="{{asset('js/zoom-image.js')}}"></script>
<script src="{{asset('js/prd_single_custom.js')}}"></script>
<script src="{{asset('js/product_review.js')}}"></script>
<!-- zoom-image js end-->
@endsection
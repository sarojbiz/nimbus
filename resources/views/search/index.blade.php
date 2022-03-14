@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<!-- JQUERY UI CSS -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                            <li class="active"><a href="#">Product List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- product_listing -->
    <main id="product_listing" class="product_listing section shop">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="shop-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Categories</h3>
                            <ul class="categor-list">
                                @if(is_object($categories) && !empty($categories))
                                    @foreach($categories as $category)
                                        <li><a href="#">{{$category->category_name}}</a></li>        
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">    
                    <div class="row prd_listing_row">                
                        @if(is_object($products) && !empty($products))
                            @php $counter = 0; @endphp
                            @foreach($products as $product)
                                @if($counter%4 == 0 && $counter > 1)                            
                                    <div class="row prd_listing_row">
                                @endif
                                    <div class="col-lg-3 col-md-6 col-6">
                                        <!-- Start Single Product -->
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product', $product->slug)}}">
                                                    @php 
                                                    $feature_image = (!empty($product->feature_image) && file_exists('uploads/products/'.$product->feature_image))?$product->feature_image:'no-feature-image.png';
                                                    @endphp
                                                    <img class="default-img" src="{{URL::asset('uploads/products/'.$feature_image)}}" alt="{{$product->pdt_name}}">
                                                    <img class="hover-img" src="{{URL::asset('uploads/products/'.$feature_image)}}" alt="{{$product->pdt_name}}">
                                                    <span class="out-of-stock">Hot</span>         
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a title="Wishlist" href="#">
                                                            <ion-icon name="heart-outline"></ion-icon><span>Add to
                                                                Wishlist</span>
                                                        </a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart" href="#" class="addToCart" data-productid="{{Crypt::encryptString($product->mcode)}}">
                                                            <img src="{{asset('images/cart-nav-black.svg')}}" width="14px"> <span>Add to cart</span> 
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{route('product', $product->slug)}}">{{$product->pdt_name}}</a></h3>
                                                <div class="product-price">
                                                    <span>Rs. {{$product->regular_price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Single Product -->
                                    </div>
                                @php $counter++; @endphp
                                @if($counter%4 == 0 && $counter > 1)                            
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    <!--.prd_listing_row ends -->
                </div>
            </div>
        </div>
    </main>
    <!-- product_listing -->
    @endsection
    @section('scripts')
    <!-- Bootstrap Bundle ends -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/prd_single_custom.js')}}"></script>
    @endsection
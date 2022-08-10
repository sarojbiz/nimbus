@extends('layouts.master')
@section('title')Category {{ucwords($title)}} @endsection
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
                            <li><a href="{{route('category.index')}}">Categories <ion-icon name="arrow-forward-outline"></ion-icon> </a></li>
                            <li class="active"><a href="#">{{ucwords($title)}}</a></li>
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
                                @if( $categories->IsNotEmpty() )
                                    @foreach($categories as $category)
                                        <li><a href="{{route('category.show', $category->category_slug)}}">{{$category->category_name}}</a>
                                        @if( $category->childrenRecursive->IsNotEmpty() )
                                            <ul class="categor-list child">
                                            @foreach($category->childrenRecursive as $child)
                                            <li><a href="{{route('category.show', $child->category_slug)}}">{{$child->category_name}}</a>
                                                @if( $child->childrenRecursive->IsNotEmpty() )
                                                <ul class="categor-list child">
                                                    @foreach($child->childrenRecursive as $grandchild)
                                                    <li><a href="{{route('category.show', $grandchild->category_slug)}}">{{$grandchild->category_name}}</a></li>  
                                                    @endforeach                                              
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                            </ul>
                                        @endif
                                        </li>        
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">    
                    @if(!is_null($message))               
                        <div class="alert alert-danger">
                            {{ $message }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                    @endif
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
                                                    <a title="Add to Wishlist" href="#" class="addToWishlist" data-productid="{{Crypt::encryptString($product->mcode)}}">
                                                            <ion-icon name="heart-outline"></ion-icon><span>Add to
                                                                Wishlist</span>
                                                        </a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart" href="#" class="addToCart" data-productid="{{Crypt::encryptString($product->slug)}}">
                                                            <img src="{{asset('images/cart-nav-black.svg')}}" width="14px"> <span>Add to cart</span> 
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                @if(isset($product->mcode) && !empty($product->mcode))
                                                    <h3><a href="{{route('product', $product->mcode)}}">{{$product->pdt_name}}</a></h3>
                                                @else
                                                    <h3>{{$product->pdt_name}}</h3>    
                                                @endif
                                                <div class="product-price">
                                                    {!! $product->show_price !!}
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
@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('content')
    <!--START #hero-slider-->
    <section id="hero-slider" class="hero-slider">
        <div class="wrap">
            <div class="row"> 
                <div class="col-md-12">
                    <div class="slideer">
                        @if($banners->IsNotEmpty())
                            @foreach($banners as $banner)
                                <div>
                                    @if($banner->anchor)    
                                    <a href="{{$banner->anchor}}" title="{{$banner->title}}" target="_blank">
                                    @endif    
                                        <img title="{{$banner->title}}" src="{{ $banner->image ? action('UploadController@getFile', ['file_path' => $banner->image, 'assetType' => 'banner_large']) : "" }}">
                                    @if($banner->anchor)    
                                    </a>
                                    @endif    
                                </div>                                
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END #hero-slider-->

    <!--START #small-banner-->
    <section id="small-banner" class="small-banner section">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-banner">
                        <a href="#">
                            <img src=" images/feat-banner/01.png">
                        </a>
                        <div class="banner_title">
                            <h5>Brush Set By Cosrx</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-banner">
                        <a href="#">
                            <img src=" images/feat-banner/02.png">
                        </a>
                        <div class="banner_title">
                            <h5>Brush Set By Pari</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-banner">
                        <a href="#">
                            <img src=" images/feat-banner/03.png">
                        </a>
                        <div class="banner_title">
                            <h5>3D Silk Lashes By Pari</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END #small-banner-->

    <!--START #featured-items-->
    <section id="category-area" class="category-area section">
        <div class="wrap">
            <div class="section_heading">
                <h2>
                    Brands We Love
                </h2>
            </div>
            <!--END .section_heading-->
            <div class="section_entry">
                <div class="owl-carousel">
                    @if(is_object($brands) && !empty($brands))
                        @foreach($brands as $brand)                        
                        <!-- Start Single Product -->
                        <div class="single_cat">
                            <div class="cat_image">
                                <img src="{{ $brand->image ? action('UploadController@getFile', ['assetType' => 'brand_thumb', 'file_path' => $brand->image]) : "" }}">
                            </div>
                            <div class="cat_title">
                                <h5>{{ $brand->name }}</h5>
                            </div>
                        </div>
                        <!-- End Single Product -->
                        @endforeach
                    @endif        
                </div>
            </div>
            <!--END .section_entry-->
        </div>
    </section>
    <!--END #featured-items-->

    <!--START #featured-items-->
    <section class="product-area featured-items section">
        <div class="wrap">
            <div class="section_heading">
                <h2>
                    NEW IN
                </h2>
            </div>
            <!--END .section_heading-->
            <div class="section_entry">
                <div class="owl-carousel">                   
                    @if(is_object($featureds) && !empty($featureds))
                        @foreach($featureds as $featured)
                            <!-- Start Single Product -->
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product', $featured->slug)}}">
                                        <img class="default-img" src="{{ $featured->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $featured->feature_image]) : "" }}" alt="{{$featured->pdt_name}}">
                                        <img class="hover-img" src="{{ $featured->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $featured->feature_image]) : "" }}" alt="{{$featured->pdt_name}}">
                                        <span class="out-of-stock">Hot</span>
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a title="Add to Wishlist" href="#" class="addToWishlist" data-productid="{{Crypt::encryptString($featured->mcode)}}">
                                                <ion-icon name="heart-outline"></ion-icon><span>Add to Wishlist</span>
                                            </a>
                                        </div>
                                        <div class="product-action-2">
                                            @if( $featured->simple_product )
                                            <a title="Add to cart" href="#" class="addToCart" data-productid="{{Crypt::encryptString($featured->mcode)}}">
                                                <img src="images/cart-nav-black.svg" width="14px"> <span>Add to Cart</span> </a>
                                            @else
                                            <a title="{{$featured->pdt_name}}" href="{{route('product', $featured->slug)}}">
                                                <img src="images/cart-nav-black.svg" width="14px"> <span>Choose Options</span> </a>
                                            @endif    
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product', $featured->slug)}}">{{$featured->pdt_name}}</a></h3>
                                    <div class="product-price">                                        
                                        {!! $featured->show_price !!}
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        @endforeach
                    @endif
                </div>
            </div>
            <!--END .section_entry-->
        </div>
    </section>
    <!--END #featured-items-->

    <!--START #featured-items-->
    <section class="product-area featured-items section">
        <div class="wrap">
            <div class="section_heading">
                <h2>
                    YOUR SKIN CARE
                </h2>
            </div>
            <!--END .section_heading-->
            <div class="section_entry">
                <div class="owl-carousel">

                @if(is_object($sellers) && !empty($sellers))
                        @foreach($sellers as $seller)
                            <!-- Start Single Product -->
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product', $seller->slug)}}">                                    
                                        <img class="default-img" src="{{ $seller->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $seller->feature_image]) : "" }}" alt="{{$seller->pdt_name}}">
                                        <img class="hover-img" src="{{ $seller->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $seller->feature_image]) : "" }}" alt="{{$seller->pdt_name}}">
                                        <span class="out-of-stock">Hot</span>
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a title="Add to Wishlist" href="#" class="addToWishlist" data-productid="{{Crypt::encryptString($seller->mcode)}}">
                                                <ion-icon name="heart-outline"></ion-icon><span>Add to Wishlist</span>
                                            </a>
                                        </div>
                                        <div class="product-action-2">
                                            @if( $seller->simple_product )
                                            <a title="Add to cart" href="#" class="addToCart" data-productid="{{Crypt::encryptString($seller->mcode)}}">
                                                <img src="images/cart-nav-black.svg" width="14px"> <span>Add to Cart</span> </a>
                                            @else
                                            <a title="{{$seller->pdt_name}}" href="{{route('product', $seller->slug)}}">
                                                <img src="images/cart-nav-black.svg" width="14px"> <span>Choose Options</span> </a>
                                            @endif    
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product', $seller->slug)}}">{{$seller->pdt_name}}</a></h3>
                                    <div class="product-price">                                        
                                        {!! $seller->show_price !!}
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        @endforeach
                    @endif
                </div>
            </div>
            <!--END .section_entry-->
        </div>
    </section>
    <!--END #featured-items-->

    <!--START #featured-items-->
    <section class="product-area featured-items section">
        <div class="wrap">
            <div class="section_heading">
                <h2>
                    BEST OF MISUMI COSMETICS
                </h2>
            </div>
            <!--END .section_heading-->
            <div class="section_entry">
                <div class="owl-carousel">

                    @if(is_object($bests) && !empty($bests))
                        @foreach($bests as $best)
                            <!-- Start Single Product -->
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product', $best->slug)}}">                                   
                                        <img class="default-img" src="{{ $best->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $best->feature_image]) : "" }}" alt="{{$best->pdt_name}}">
                                        <img class="hover-img" src="{{ $best->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $best->feature_image]) : "" }}" alt="{{$best->pdt_name}}">
                                        <span class="out-of-stock">Hot</span>
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a title="Add to Wishlist" href="#" class="addToWishlist" data-productid="{{Crypt::encryptString($best->mcode)}}">
                                                <ion-icon name="heart-outline"></ion-icon><span>Add to Wishlist</span>
                                            </a>
                                        </div>
                                        <div class="product-action-2">
                                            @if( $best->simple_product )
                                            <a title="Add to cart" href="#" class="addToCart" data-productid="{{Crypt::encryptString($best->mcode)}}">
                                                <img src="images/cart-nav-black.svg" width="14px"> <span>Add to Cart</span> </a>
                                            @else
                                            <a title="{{$best->pdt_name}}" href="{{route('product', $best->slug)}}">
                                                <img src="images/cart-nav-black.svg" width="14px"> <span>Choose Options</span> </a>
                                            @endif    
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product', $best->slug)}}">{{$best->pdt_name}}</a></h3>
                                    <div class="product-price">                                        
                                        {!! $best->show_price !!}
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        @endforeach
                    @endif
                    
                </div>
            </div>
            <!--END .section_entry-->
        </div>
    </section>
    <!--END #featured-items-->
@endsection
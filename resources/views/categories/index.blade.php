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
                        @if( $allCategories->IsNotEmpty() )
                            @php $counter = 0; @endphp
                            @foreach($allCategories as $category)
                                @if($counter%4 == 0 && $counter > 1)                            
                                    <div class="row prd_listing_row">
                                @endif
                                    <div class="col-lg-3 col-md-6 col-6">
                                        <!-- Start Single category -->
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('category.show', $category->category_slug)}}">
                                                    <img class="default-img" src="{{ action('UploadController@getFile', ['assetType' => 'category_thumb', 'file_path' => $category->category_image ? $category->category_image : 'no-image.png']) }}" alt="{{$category->category_name}}">
                                                    <img class="hover-img" src="{{ action('UploadController@getFile', ['assetType' => 'category_thumb', 'file_path' => $category->category_image ? $category->category_image : 'no-image.png']) }}" alt="{{$category->category_name}}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{route('category.show', $category->category_slug)}}">{{$category->category_name}}</a></h3>
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
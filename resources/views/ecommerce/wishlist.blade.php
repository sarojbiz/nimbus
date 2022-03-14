@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                        <li class="active"><a href="#">My Wishlilst</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- START #cart -->
<main id="cart" class="cart section shop">
    <div class="wrap">
        <div class="cart_listing">
            <table class="table shopping-summery wishlist" id="wishlist_table">
                <thead>
                    <tr class="main-hading">
                        <th class="text-center">PRODUCT</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">UNIT PRICE</th>
                        <th class="text-center">
                            <ion-icon name="trash-outline"></ion-icon>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($products->isNotEmpty())
                        @foreach($products as $product)
                            @php 
                            $feature_image = (!empty($product->feature_image) && file_exists(public_path('uploads/products/thumb/'.$product->feature_image)))?$product->feature_image:'no-feature-image.png';
                            @endphp
                            <tr class="{{$product->slug}}">
                            <td class="image text-center" data-title="No"><img src="{{URL::asset('uploads/products/thumb/'.$feature_image)}}" alt="{{$product->pdt_name}}">
                            </td>
                            <td class="product-des text-center" data-title="description">
                                <p class="product-name"><a href="{{route('product', $product->slug)}}">{{$product->pdt_name}}</a></p>
                                <p class="product-des">{{$product->product_short_description}}</p>
                            </td>
                            <td class="price text-center" data-title="Price">{!! $product->show_price !!}</span></td>
                            <td class="action text-center" data-title="Remove"><a href="#" data-productid="{{$product->mcode}}" class="remove removeFromWishlist" title="Remove this item">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    @else   
                        <tr><td colspan="4">No Products have been added in the wishlist yet.</td></tr>    
                    @endif
                </tbody>
            </table>
            <!--/ End Shopping Summery -->
        </div>
        <!-- cart_listing end -->

    </div>
</main>
<!-- END cart -->

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
@endsection
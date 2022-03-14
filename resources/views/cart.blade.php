@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<!-- JQUERY UI CSS -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<!-- START #cart -->
<main id="cart" class="cart section shop">
        <div class="wrap">
            <div class="cart_listing">
                <form name="cart_table" id="cart_table" class="cart_table" method="post" action="{{route('update_item')}}">
                    <table class="table shopping-summery">
                        <thead>
                            <tr class="main-hading">
                                <th width="15%">PRODUCT</th>
                                <th width="25%">NAME</th>
                                <th width="20%" class="text-center">UNIT PRICE</th>
                                <th width="15%" class="text-center">QUANTITY</th>
                                <th width="15%" class="text-center">TOTAL</th>
                                <th width="10%" class="text-center">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_object($items) && !empty($items))
                                @foreach($items as $item)
                                    <tr class="{{$item->id}}">
                                        <td class="image" data-title="No">                                       
                                            <img class="default-img" src="{{ $item->associatedModel->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $item->associatedModel->feature_image]) : "" }}" alt="{{$item->name}}" width="100px">                                        
                                        </td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="{{route('product', $item->associatedModel->slug)}}">{{$item->name}}</a></p>
                                            <p class="product-des">
                                                @if($item->attributes->size_name)
                                                Size : {{$item->attributes->size_name}}
                                                @endif
                                                @if($item->attributes->color_name)
                                                , Color : {{$item->attributes->color_name}}
                                                @endif
                                            </p>  
                                        <p class="product-des">{{$item->pdt_short_description}}</p>
                                        </td>
                                        <td class="price text-center" data-title="Price">{!! $item->attributes->html_format_price !!}</span></td>
                                        <td class="qty" data-title="Qty">
                                            <!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number" data-type="minus"
                                                        data-field="quant[{{$item->id}}]">
                                                        <ion-icon class="ti-minus" name="remove-outline"></ion-icon>
                                                    </button>
                                                </div>
                                                <input type="text" name="quant[{{$item->id}}]" class="input-number" data-min="1" data-max="100" value="{{$item->quantity}}">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                                        data-field="quant[{{$item->id}}]">
                                                        <ion-icon class="ti-plus" name="add-outline"></ion-icon>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input Order -->
                                        </td>
                                        <td class="total-amount text-center" data-title="Total">Rs. <span>{{$item->totalprice}}</span></td>
                                        <td class="action" data-title="Remove"><a href="#" class="removeFromCart" data-cartid="{{$item->id}}">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ csrf_field() }}
                </form>
                <!--/ End Shopping Summery -->
            </div>
            <!-- cart_listing end -->

            <div class="total-amount">
                <div class="row">
                    <div class="col-lg-8 col-md-5 col-12">
                        <div class="left">
                            <div class="coupon">
                                <form action="#" target="_blank">
                                    <input name="Coupon" placeholder="Enter Your Coupon">
                                    <button class="btn">Apply</button>
                                </form>                                
                            </div>
                            <div class="checkbox">
                                <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox" checked="checked">
                                    Free Shipping</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7 col-12">
                        <div class="right">
                            <ul>
                                <li>Cart Subtotal<span class="mini_cart_total_amt">{{$total}}</span><span>Rs.</span></li>
                                <li>Shipping<span>Free</span></li>
                                <li class="last">You Pay<span class="mini_cart_total_amt">{{$total}}</span><span>Rs.</span></li>
                            </ul>
                            <div class="button5">
                                <a href="#" class="btn" id="submit_cart_table">Update Cart</a>
                                <a href="{{route('checkout')}}" class="btn">Checkout</a>
                                <a href="{{route('home')}}" class="btn">Continue shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- cart_total_amount end -->
        </div>
    </main>
    <!-- END cart -->
    @endsection
    @section('scripts')
    <!-- Bootstrap Bundle ends -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/zoom-image.js')}}"></script>
    <script src="{{asset('js/prd_single_custom.js')}}"></script>
    @endsection
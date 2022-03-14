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
                            <li class="active"><a href="#">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->


<main id="checkout" class="checkout section shop">
    <!-- Form -->
    <form name="checkout_form" id="checkout_form" class="form" method="post" action="{{route('process.checkout')}}">
    {{csrf_field()}}

        <div class="wrap">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h1>Checkout</h1>
                        <p>Please register in order to checkout more quickly</p>
                        <div class="checkout_process">
                        </div>
                            <div class="shipping_address checkout_form_wrap">
                                <h3>Shipping Address</h3>
                                @include('ecommerce.checkout.shipping')
                            </div>
                            <div class="billing_address checkout_form_wrap hide" id="billing_detail_form">
                                <h3>Billing Address</h3>
                                @include('ecommerce.checkout.personal')
                            </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>CART TOTALS</h2>
                            <div class="content">
                                <ul>
                                    <li>Sub Total<span>Rs {{$subtotal}}</span></li>
                                    <li>(+) Shipping<span>Free</span></li>
                                    <li class="last">Total<span>Rs {{$gettotal}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Payments</h2>
                            <div class="content">
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="1"><input name="payment_method" value="cod" id="1" type="checkbox" checked="checked" disabled="disabled">
                                        Cash On Delivery</label>
                                </div>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Payment Method Widget -->
                        <div class="single-widget payement">
                            <div class="content">
                                <img src="images/payment-method.png" alt="#">
                            </div>
                        </div>
                        <!--/ End Payment Method Widget -->
                        <!-- Button Widget -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <input type="submit" name="submit" class="btn" value="proceed to checkout">
                                    <p>By checkout, you agree to create an account.</p>
                                </div>
                            </div>
                        </div>
                        <!--/ End Button Widget -->
                    </div>
                </div>   
            </div>
        </div>

    </form>
    <!--/ End Form -->
</main>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/checkout.js')}}"></script>
@endsection

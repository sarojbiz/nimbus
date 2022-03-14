
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

    <!-- product_listing -->
    <main id="checkout" class="checkout section shop">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h1>Error in Checkout</h1>
                        <p>{{$message}}</p>
                        <div class="button">
                            <a href="{{route('home')}}" class="btn">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- product_listing -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
@endsection

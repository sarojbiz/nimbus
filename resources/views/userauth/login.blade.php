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
                            <li class="active">Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <!-- product_listing -->
    <main id="login" class="login section shop">
        <div class="wrap">
            <div class="row">
                <div class="login-form col-lg-8">
                    <div class="login_header">
                        <h3>Customer Login:</h3>
                        <p>@include('errors.errors')</p>
                    </div>
                    <!-- Form -->
                    <form class="form" method="post" action="{{route('user.login')}}" autocomplete="off">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" placeholder="Email Address"  value="{{ old('email') }}" required="required">
                        </div>
                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" name="password" placeholder="Password" required="required">
                        </div>
                        <div class="forgot-password">
                            <a href="{{route('user.register')}}" style="float:left;">Create new account</a>
                            <a href="{{route('forgot.password')}}">Forgot Password?</a>
                        </div>
                        <div class="form-group remember">
                            <input id="cbox" name="remember" value="1" type="checkbox">
                            <label>Remember me</label>
                        </div>
                        <div class="single-widget">
                            <div class="content">
                                <div class="button">
                                    <input class="btn" type="submit" value="Login">
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>
            </div>
        </div>
    </main>
    <!-- product_listing -->
@endsection
@section('scripts')
 <!-- Bootstrap Bundle ends -->
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
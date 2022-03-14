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
                            <li class="active">Forgot Password</li>
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

                <div class="login-form col-lg-4">
                    <div class="login_header">
                        <h3>Reset Passcode</h3>
                        <p>@include('errors.errors')</p>
                    </div>

                    <!-- Form -->
                    <form class="form" method="post" action="{{route('forgot.password')}}" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="mobile" placeholder="Enter Phone Number" required="required" value="{{ old('mobile') }}">
                        </div>
                        <div class="forgot-password">
                            <a href="{{route('user.login')}}">Back To Login</a>
                        </div>
                        <div class="single-widget">
                            <div class="content">
                                <div class="button">
                                    <input class="btn" type="submit" value="Submit">
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
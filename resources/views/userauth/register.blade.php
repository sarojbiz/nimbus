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
                        <li class="active">Create Account</li>
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
                    <h3>Create An Account</h3>
                    <p>Sign up for a free account at Misumi Cosmetics</p>
                    <p>@include('errors.errors')</p>
                </div>
                <!-- Form -->
                <form class="form" method="post" action="{{route('user.register')}}" autocomplete="off">
                {{csrf_field()}}
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" name="first_name" placeholder="" value="{{ old('first_name') }}" required="required">
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" required="required" value="{{ old('last_name') }}">
                    </div>
                    <div class="form-group">
                        <label>Your Email Address *</label>
                        <input type="email" name="email" required="required" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label>Your Password *</label>
                        <input type="password" name="password" required="required" value="{{ old('password') }}">
                    </div>
                    <div class="form-group">Agree Terms
                        <input type="checkbox" name="agree" required="required" @if(old('agree') == 1)checked="checked"@endif>
                    </div>
                    <div class="forgot-password">
                        <a href="{{route('user.login')}}">Already have an Account?</a>
                    </div>
                    <div class="single-widget">
                        <div class="content">
                            <div class="button">
                                <input class="btn" type="submit" value="Create An Account">
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
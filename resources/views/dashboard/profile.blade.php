@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!--START my_account -->
<main id="my_account" class="my_account section shop">
    <div class="wrap">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                @include('dashboard.sidebar')
            </div>
            <!--.account-sidebar wrapper ends-->

            <div class="col-lg-9 col-md-8 col-12 account_entry">
                <div class="account_title">
                    <h1>My Profile</h1>
                </div>
                <div class="row account_orders acc_row">
                    <div class="col-lg-12">
                        <div class="accont_block">
                            <div class="accblock_title">
                                <h4>Edit Profile : </h4>
                                <h6>Member ID : {{ Auth::user()->member_id }}</h6>
                                @include('errors.errors')
                            </div>
                            <div class="accblock_body">
                            {!! Form::open(['action' => 'Dashboard\ProfileController@update', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="form-group">
                                {!! Form::label('first_name', 'First Name *')!!}
                                {!! Form::text('first_name', Auth::user()->first_name, ['class' => 'form-control'.($errors->has('first_name') ? ' is-invalid' : ''), 'placeholder' => 'First Name', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('last_name', 'Last Name')!!}
                                {!! Form::text('last_name', Auth::user()->last_name, ['class' => 'form-control'.($errors->has('last_name') ? ' is-invalid' : ''), 'placeholder' => 'Last Name']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('email', 'Email address *')!!}
                                {!! Form::email('email', Auth::user()->email, ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email address', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>                               
                            </div>
                            <div class="form-group">
                                {!! Form::label('mobile', 'Mobile *')!!}
                                {!! Form::text('mobile', Auth::user()->mobile, ['class' => 'form-control'.($errors->has('mobile') ? ' is-invalid' : ''), 'placeholder' => 'Mobile', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('mobile') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('password', 'Password')!!}
                                {!! Form::password('password', ['class' => 'form-control'.($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Password']) !!}
                                <small id="password" class="form-text text-muted">Leave blank for no password change.</small>
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('password_confirmation', 'Confirm Password')!!}
                                {!! Form::password('password_confirmation', ['class' => 'form-control'.($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => 'Confirm Password']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('password_confirmation') }}
                                </div>                             
                            </div>
                            <button type="submit" class="btn btn-sm">Update</button>
                            {!! Form::close() !!}
                            </div>
                        </div>
                        <!--.accont_block ends-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END my_account -->

@endsection
@section('scripts')

@endsection
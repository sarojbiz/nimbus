@extends('layouts.master')
@section('title') {{$title}} @endsection
@section('stylesheets')
<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css" />
<style>
.nice-select.wide{
    width: 100%;
    margin-bottom: 15px;
}
</style>
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
                    <h1>Address Book</h1>
                </div>
                <div class="row account_orders acc_row">
                    <div class="col-lg-12">
                        <div class="accont_block">
                            <div class="accblock_title">
                                <h4>Edit Address Book : </h4>
                                <h6>Member ID : {{ Auth::user()->member_id }}</h6>
                                @include('errors.errors')
                            </div>
                            <div class="accblock_body">
                            {!! Form::open(['action' => 'Dashboard\AddressbookController@update', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="form-group">
                                {!! Form::label('street_address', 'Street Address *')!!}
                                {!! Form::text('street_address', optional(Auth::user()->userAddress)->street_address, ['class' => 'form-control'.($errors->has('street_address') ? ' is-invalid' : ''), 'placeholder' => 'Street Address', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('street_address') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('city', 'City *')!!}
                                {!! Form::text('city', optional(Auth::user()->userAddress)->city, ['class' => 'form-control'.($errors->has('city') ? ' is-invalid' : ''), 'placeholder' => 'City', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('postal_code', 'Zip / Postal Code *')!!}
                                {!! Form::text('postal_code', optional(Auth::user()->userAddress)->postal_code, ['class' => 'form-control'.($errors->has('postal_code') ? ' is-invalid' : ''), 'placeholder' => 'Zip / Postal Code', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('postal_code') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('provience', 'State / Provience *')!!}
                                {!! Form::select('provience', $proviences, optional(Auth::user()->userAddress)->provience, ['class' => 'form-control wide'.($errors->has('provience') ? ' is-invalid' : ''), 'placeholder' => 'Select State / Provience', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('provience') }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('country', 'Country *')!!}
                                {!! Form::select('country', $countries, optional(Auth::user()->userAddress)->country, ['class' => 'form-control wide'.($errors->has('country') ? ' is-invalid' : ''), 'placeholder' => 'Select Country', 'required' => 'required']) !!}
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
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
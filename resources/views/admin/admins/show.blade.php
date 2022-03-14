@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ action('Admin\DashboardController@index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admin</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Admin : {{$admin->member_id}}</h6>
        </div>
        <div class="card-body">
            <form>
            <div class="form-group">
                {!! Form::label(null, 'First Name :') !!}
                {!! Form::label(null, $admin->first_name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(null, 'Last Name :') !!}
                {!! Form::label(null, $admin->last_name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(null, 'Email :') !!}
                {!! Form::label(null, $admin->email, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(null, 'Mobile :') !!}
                {!! Form::label(null, $admin->mobile, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(null, 'Status :') !!}
                {!! Form::label(null, GeneralStatus::fromValue($admin->status)->description, ['class' => 'form-control']) !!}
            </div>
            <a href="{{ action('Admin\AdminController@index') }}" class="btn btn-primary">Back</a>
            </form>
        </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection  
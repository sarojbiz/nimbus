@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ action('Admin\DashboardController@index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Banner</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Title : {{$banner->title}}</h6>
        </div>
        <div class="card-body">
            <form>
            <div class="form-group">
                {!! Form::label(null, 'Title :') !!}
                {!! Form::label(null, $banner->title, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(null, 'Link :') !!}
                {!! Form::label(null, $banner->anchor, ['class' => 'form-control']) !!}
            </div>                                                                                    
            <div class="form-group">
                <label for="image">Image :</label>
                <img class="form-control" src="{{ $banner->image ? action('Admin\UploadController@getFile', ['file_path' => $banner->image, 'assetType' => 'banner_thumb']) : "" }}" title="{{$banner->image}}" style="width:200px; height:auto;" />
            </div>                   
            <div class="form-group">
                {!! Form::label(null, 'Status :') !!}
                {!! Form::label(null, GeneralStatus::fromValue($banner->status)->description, ['class' => 'form-control']) !!}
            </div>
            <a href="{{ action('Admin\BannerController@index') }}" class="btn btn-primary">Back</a>
            </form>
        </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection  
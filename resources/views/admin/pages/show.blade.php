@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ action('Admin\DashboardController@index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Brand</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Title : {{$page->name}}</h6>
        </div>
        <div class="card-body">
            <form>
            <div class="form-group">
                {!! Form::label(null, 'Title :') !!}
                {!! Form::label(null, $page->name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Content :') !!}
                {!! Form::textarea('description', $page->content, ['class' => 'form-control']) !!}
            </div>
            @if( $page->image )        
                <div class="form-group">
                    <label for="image">Feature Image :</label>
                    <img class="form-control" src="{{ $page->image ? action('Admin\UploadController@getFile', ['file_path' => $page->image, 'assetType' => 'page_thumb']) : "" }}" title="{{$page->image}}" style="width:200px; height:auto;" />
                </div>
            @endif       
            <div class="form-group">
                {!! Form::label(null, 'Status :') !!}
                {!! Form::label(null, GeneralStatus::fromValue($page->status)->description, ['class' => 'form-control']) !!}
            </div>
            <a href="{{ action('Admin\PageController@index') }}" class="btn btn-primary">Back</a>
            </form>
        </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection  
@section('scripts')
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>
    CKEDITOR.replace( 'description', {readOnly:true} );    
</script>
@endsection   
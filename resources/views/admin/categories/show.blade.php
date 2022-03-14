@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Category Detail</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ action('Admin\DashboardController@index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Category : {{$category->category_name}}</h6>
        </div>
        <div class="card-body">
            <form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label(null, 'Category Name')!!}
                        {!! Form::label(null, $category->category_name, ['class' => 'form-control', 'placeholder' => 'Category Name']) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label(null, 'Parent Name')!!}
                        {!! Form::label(null, ($category->parent_category_id > 0)?$category->parent->category_name:'', ['class' => 'form-control', 'placeholder' => 'Parent Name']) !!}
                    </div>
                </div>
            </div>        
            <div class="form-group">
                <label for="category_description">Description</label>
                <textarea name="category_description" class="form-control" id="category_description" rows="3">{!! $category->category_description !!}</textarea>
            </div> 
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label(null, 'Level')!!}
                        {!! Form::label(null, $category->category_level, ['class' =>
                        'form-control', 'placeholder' => 'category Level']) !!}
                    </div>  
                    <div class="form-group">
                        {!! Form::label(null, 'Status')!!}
                        {!! Form::label(null, GeneralStatus::fromValue($category->status)->description, ['class' => 'form-control', 'placeholder' => 'category status']) !!}
                    </div>                    
                    <div class="form-group">
                        <label for="category_image">Category Image</label>
                        <img class="form-control" src="{{ action('Admin\UploadController@getFile', ['assetType' => 'category_thumb', 'file_path' => $category->category_image ? $category->category_image : 'no-image.jpg']) }}" style="width:200px; height:auto;" />
                    </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group">
                        {!! Form::label(null, 'Show in Menu')!!}
                        {!! Form::label(null, $category->show_menu_label, ['class' => 'form-control', 'placeholder' => 'category status']) !!}
                    </div>                      
                </div>
            </div>
            <a href="{{ action('Admin\CategoryController@index') }}" class="btn btn-primary">Back</a>
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
    CKEDITOR.replace( 'category_description', {readOnly:true} );
</script>
@endsection   
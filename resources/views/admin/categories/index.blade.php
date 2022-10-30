@extends('admin.master')
@section('title', $title)
@section('stylesheets')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Category Listing</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categories</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
                <a href="{{ action('Admin\CategoryController@create') }}" title="Add new category" class="btn btn-primary mb-1">Add New</a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Menu Level</th>
                        <th>Menu Item</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_object($categories) && !empty($categories))
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$category->category_name}}</td>
                                @if($category->parent_category_id == 0)
                                    <td>&nbsp;</td>
                                @else
                                    <td>{{optional($category->parent)->category_name}}</td>
                                @endif
                                <td>{{$category->category_level}}</td>
                                <td>{{$category->menu_item ? 'Yes' : 'No'}}</td>
                                <td>{{GeneralStatus::fromValue($category->status)->description}}</td>
                                <td>
                                @if(!is_null($category->created_by))
                                    {{$category->createdBy->first_name.' '.$category->createdBy->last_name}}
                                @endif
                                </td>
                                <td>
                                @if(!is_null($category->updated_by))
                                    {{$category->createdBy->first_name.' '.$category->createdBy->last_name}}
                                @endif
                                </td>
                                <th>
                                    <a href="{{ action('Admin\CategoryController@edit', $category->category_id) }}" title="Edit Category">
                                        <i class="fas fa-pen fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\CategoryController@destroy', $category->category_id) }}" title="Delete Category" onclick="return confirm('Are you sure you want to delete?');">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\CategoryController@show', $category->category_id) }}" title="View Category">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                </th>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
@section('scripts')
<!-- Page level plugins -->
<script src="{{asset('/backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script>
    jQuery(function($){
      $('#dataTable').DataTable();
    });
  </script>
@endsection
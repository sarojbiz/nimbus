@extends('admin.master')
@section('title', $title)
@section('stylesheets')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pages</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Pages</h6>
                <a href="{{ action('Admin\PageController@create') }}" title="Add new page" class="btn btn-primary mb-1">Add New</a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                        <th>Name</th>                              
                        <th>Featured Image</th>                        
                        <th>Status</th>   
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_object($pages) && !empty($pages))
                            @foreach($pages as $page)
                            <tr>
                                <td>{{$page->name}}</td>                                
                                <td><img width="200px" src="{{ $page->image ? action('Admin\UploadController@getFile', ['file_path' => $page->image, 'assetType' => 'page_thumb']) : "" }}" /></td>
                                <td>{{GeneralStatus::fromValue($page->status)->description}}</td>
                                <td>
                                @if(!is_null($page->created_by))
                                    {{$page->createdBy->first_name.' '.$page->createdBy->last_name}}
                                @endif
                                </td>
                                <td>
                                @if(!is_null($page->updated_by))
                                    {{$page->createdBy->first_name.' '.$page->createdBy->last_name}}
                                @endif
                                </td>
                                <th>
                                    <a href="{{ action('Admin\PageController@edit', $page->id) }}" title="Edit Page">
                                        <i class="fas fa-pen fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\PageController@destroy', $page->id) }}" title="Delete Page" onclick="return confirm('Are you sure you want to delete?');">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\PageController@show', $page->id) }}" title="View Page">
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
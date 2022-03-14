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
        <li class="breadcrumb-item active" aria-current="page">Colors</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Colors</h6>
                <a href="{{ action('Admin\ColorController@create') }}" title="Add new color" class="btn btn-primary mb-1">Add New</a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                        <th>Name</th>      
                        <th style="width:40%">Description</th>      
                        <th>Status</th>   
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colors as $color)
                        <tr>
                            <td>{{$color->name}}</td> 
                            <td>{{$color->description}}</td>                                                                
                            <td>{{GeneralStatus::fromValue($color->status)->description}}</td>
                            <td>
                            @if(!is_null($color->created_by))
                                {{$color->createdBy->first_name.' '.$color->createdBy->last_name}}
                            @endif
                            </td>
                            <td>
                            @if(!is_null($color->updated_by))
                                {{$color->createdBy->first_name.' '.$color->createdBy->last_name}}
                            @endif
                            </td>
                            <th>
                                <a href="{{ action('Admin\ColorController@edit', $color->id) }}" title="Edit color">
                                    <i class="fas fa-pen fa-fw"></i>
                                </a>
                                <a href="{{ action('Admin\ColorController@destroy', $color->id) }}" title="Delete color" onclick="return confirm('Are you sure you want to delete?');">
                                    <i class="fas fa-trash fa-fw"></i>
                                </a>
                                <a href="{{ action('Admin\ColorController@show', $color->id) }}" title="View color">
                                    <i class="fas fa-eye fa-fw"></i>
                                </a>
                            </th>
                        </tr>
                        @empty
                            <tr><td colspan="6">No data found.</td></tr>
                        @endforelse
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
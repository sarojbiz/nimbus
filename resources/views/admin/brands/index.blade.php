@extends('admin.master')
@section('title', $title)
@section('stylesheets')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Brands Listing</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Brands</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Brands</h6>
                <a href="{{ action('Admin\BrandController@create') }}" title="Add new brand" class="btn btn-primary mb-1">Add New</a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                        <th>Name</th>      
                        <th>Status</th>   
                        <th>Logo</th>                        
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_object($brands) && !empty($brands))
                            @foreach($brands as $brand)
                            <tr>
                                <td>{{$brand->name}}</td>                                
                                <td><img width="200px" src="{{ $brand->image ? action('Admin\UploadController@getFile', ['file_path' => $brand->image, 'assetType' => 'brand_thumb']) : "" }}" /></td>
                                <td>{{GeneralStatus::fromValue($brand->status)->description}}</td>
                                <td>
                                @if(!is_null($brand->created_by))
                                    {{$brand->createdBy->first_name.' '.$brand->createdBy->last_name}}
                                @endif
                                </td>
                                <td>
                                @if(!is_null($brand->updated_by))
                                    {{$brand->createdBy->first_name.' '.$brand->createdBy->last_name}}
                                @endif
                                </td>
                                <th>
                                    <a href="{{ action('Admin\BrandController@edit', $brand->id) }}" title="Edit Category">
                                        <i class="fas fa-pen fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\BrandController@destroy', $brand->id) }}" title="Delete Brand" onclick="return confirm('Are you sure you want to delete?');">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </a>
                                    <a href="{{ action('Admin\BrandController@show', $brand->id) }}" title="View Brand">
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
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
        <li class="breadcrumb-item active" aria-current="page">Members</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Members</h6>
                <a href="{{ action('Admin\MemberController@create') }}" title="Add new member" class="btn btn-primary mb-1">Add New</a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                        <th>Member ID</th>      
                        <th>Full Name</th>  
                        <th>Email</th>     
                        <th>Mobile</th>      
                        <th>Status</th>   
                        <th>Registered Date</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>{{$member->member_id}}</td> 
                            <td>{{$member->fullname}}</td> 
                            <td>{{$member->email}}</td>
                            <td>{{$member->mobile}}</td> 
                            <td>{{GeneralStatus::fromValue($member->status)->description}}</td>
                            <td>{{Carbon\Carbon::parse($member->created_at)->format('Y-m-d g:i A')}}</td>
                            <th>
                                <a href="{{ action('Admin\MemberController@edit', $member->id) }}" title="Edit member">
                                    <i class="fas fa-pen fa-fw"></i>
                                </a>
                                <a href="{{ action('Admin\MemberController@destroy', $member->id) }}" title="Delete member" onclick="return confirm('Are you sure you want to delete?');">
                                    <i class="fas fa-trash fa-fw"></i>
                                </a>
                                <a href="{{ action('Admin\MemberController@show', $member->id) }}" title="View member">
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
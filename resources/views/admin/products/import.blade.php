@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Import Products</li>
    </ol>
</div>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Product Details: </h6>
        </div>
        <div class="card-body">
            {!! Form::open(['action' => 'Admin\ProductController@importStore', 'files' => true]) !!}
            <div class="row">
            <div class="col-lg-6">    
                <div class="form-group">
                    {!! Form::label('sample_excel_form', 'Sample Excel Template :') !!}       
                    <a href="{{ action('Admin\ProductController@getSampleExcel') }}" class="btn btn-icon btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Download Sample Excel Template"><i class="fas fa-download"></i></a>
                </div>    
                <div class="form-group">
                    {!! Form::label(null, 'Product Excel File * :') !!}    
                    {!! Form::file('excel_file', ['class' => 'form-control-file', 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel']); !!}
                    <p><small>Recommended File: .xls, .xlsx</small></p>
                    <div class="invalid-feedback{{($errors->has('excel_file') ? ' d-block' : '')}}">
                        {{ $errors->first('excel_file') }}
                    </div>
                </div>
                <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 mb-12">
                    <!-- Simple Tables -->
                    <div class="card">                        
                        <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Key</th>
                                <th>Values</th>                                
                            </tr>
                            </thead>
                            <tbody>
                            <tr>                                
                                <td>Product Type :</td>
                                <td>i. Simple     ii. Variable</td>                                
                            </tr>
                            <tr>                                
                                <td>Sales Product :</td>
                                <td>i. Yes     ii. No</td>                                
                            </tr>
                            <tr>                                
                                <td>Status :</td>
                                <td>i. Enabled     ii. Disabled</td>                                
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                    </div>
                </div>
                </div> 
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ action('Admin\ProductController@index') }}" class="btn btn-primary">Back</a>
            </div>            
            {!! Form::close() !!}
        </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
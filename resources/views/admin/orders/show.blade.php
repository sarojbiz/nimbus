@extends('admin.master')
@section('title', $title)
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Order Detail</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Order</li>
    </ol>
</div>
@include('errors.errors')
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Order No : {{$order->order_no}}</h6>
        </div>
        <div class="card-body">
        {!! Form::model($order, ['action' => ['Admin\OrderController@update', $order->id], 'method' => 'PATCH']) !!}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="b_first_name">First Name</label>
                        <input type="text" class="form-control" id="b_first_name" value="{{$order->b_first_name}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="b_last_name">Last Name</label>
                        <input type="text" class="form-control" id="b_last_name" value="{{$order->b_last_name}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="b_email">Email</label>
                        <input type="text" class="form-control" value="{{$order->b_email}}" id="b_email" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="b_phone">Phone</label>
                        <input type="text" class="form-control" value="{{$order->b_phone}}" id="b_phone" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="b_street_address">Street Address</label>
                        <input type="text" class="form-control" value="{{$order->b_street_address}}" id="b_street_address" readonly="readonly">
                    </div> 
                    <div class="form-group">
                        <label for="b_city">City</label>
                        <input type="text" class="form-control" value="{{$order->b_city}}" id="b_city" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="b_postcode">Postal Code</label>
                        <input type="text" class="form-control" value="{{$order->b_postcode}}" id="b_postcode" readonly="readonly">
                    </div>
                    <div class="form-group">
                        {!! Form::label('b_state', 'State / Provience')!!}
                        {!! Form::select('b_state', $proviences, $order->b_state, ['class' => 'form-control', 'id' => 'b_state', 'placeholder' => 'Select State / Provience', 'readonly' => 'readonly', 'disabled' => 'disabled']) !!}
                    </div> 
                    <div class="form-group">
                        {!! Form::label('b_country', 'Country')!!}
                        {!! Form::select('b_country', $countries, $order->b_country, ['class' => 'form-control', 'id' => 'b_country', 'placeholder' => 'Select Country', 'readonly' => 'readonly', 'disabled' => 'disabled']) !!}
                    </div> 
                </div>
                <div class="col-lg-6">
                <div class="form-group">
                        <label for="s_first_name">First Name</label>
                        <input type="text" class="form-control" id="s_first_name" value="{{$order->s_first_name}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="s_last_name">Last Name</label>
                        <input type="text" class="form-control" id="s_last_name" value="{{$order->s_last_name}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="s_email">Email</label>
                        <input type="text" class="form-control" value="{{$order->s_email}}" id="s_email" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="s_phone">Phone</label>
                        <input type="text" class="form-control" value="{{$order->s_phone}}" id="s_phone" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="s_street_address">Street Address</label>
                        <input type="text" class="form-control" value="{{$order->s_street_address}}" id="s_street_address" readonly="readonly">
                    </div> 
                    <div class="form-group">
                        <label for="s_city">City</label>
                        <input type="text" class="form-control" value="{{$order->s_city}}" id="s_city" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="s_postcode">Postal Code</label>
                        <input type="text" class="form-control" value="{{$order->s_postcode}}" id="s_postcode" readonly="readonly">
                    </div>
                    <div class="form-group">
                        {!! Form::label('s_state', 'State / Provience')!!}
                        {!! Form::select('s_state', $proviences, $order->s_state, ['class' => 'form-control', 'id' => 's_state', 'placeholder' => 'Select State / Provience', 'readonly' => 'readonly', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('s_country', 'Country')!!}
                        {!! Form::select('s_country', $countries, $order->s_country, ['class' => 'form-control', 'id' => 's_country', 'placeholder' => 'Select Country', 'readonly' => 'readonly', 'disabled' => 'disabled']) !!}
                    </div>                                       
                </div>
            </div>            
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                            <th>Total</th>                        
                            </tr>
                        </thead>
                        <tbody>                        
                            @foreach($order->orderProducts as $product)
                            <tr>
                                <td>
                                {{$product->product_name}} 
                                <br />
                                @if($product->color_name)
                                <sub>Color : {{$product->color_name}}</sub>
                                @endif
                                @if($product->size_name)
                                <sub>, Size : {{$product->size_name}}</sub>
                                @endif
                                </td>                                
                                <td>{{$product->price}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{'Rs '. round($product->subtotal, 2)}}</td>
                                <td>{{'Rs '. round($product->total, 2)}}</td>                            
                            </tr>
                            @endforeach                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <th>Grand Total :</th>
                                <th>{{'Rs '. round($order->total, 2)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>   
            </div>             
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Update Order</h6>
            </div>            
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="order_status_id" class="mt-3">Shipping Status * :</label>
                        {!! Form::select('order_status_id', $shippingStatues, null,
                        ['class' => 'form-control'.($errors->has('order_status_id') ? ' is-invalid' : ''), 'placeholder' => '--- Select Shipping Status ---', 'required' => 'required']) !!}
                        <div class="invalid-feedback">
                            {{ $errors->first('order_status_id') }}
                        </div>
                    </div> 
                </div> 
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="status" class="mt-3">Order Status * :</label>
                        {!! Form::select('status', $statuses, null,
                        ['class' => 'form-control'.($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => '--- Select Status ---', 'required' => 'required']) !!}
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div> 
                    </div>
                </div>
            </div>
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a href="{{ action('Admin\OrderController@index') }}" class="btn btn-primary">Back</a>
            </form>
        </div>        
    </div>
</div>
<!--Row-->
@endsection
@section('scripts')

@endsection   
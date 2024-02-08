<div class="form-group row">
    <div class="col-sm-12 col-md-6">
    {!! Form::label('first_name', 'First Name * :') !!}       
    {!! Form::text('first_name', null, ['class' => 'form-control'.($errors->has('first_name') ? ' is-invalid' : ''), 'placeholder' => 'First Name', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('first_name') }}
    </div>    
    </div>    

    <div class="col-sm-12 col-md-6">
        {!! Form::label('last_name', 'Last Name * :') !!}       
        {!! Form::text('last_name', null, ['class' => 'form-control'.($errors->has('first_name') ? ' is-invalid' : ''), 'placeholder' => 'Last Name', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('last_name') }}
        </div>    
    </div>    
</div>
<div class="form-group row">
    <div class="col-sm-12 col-md-6">
        {!! Form::label('email', 'Email * :') !!}       
        {!! Form::text('email', null, ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('email') }}
        </div>    
    </div>
    <div class="col-sm-12 col-md-6">
        {!! Form::label('password', 'Password * :') !!}       
        {!! Form::text('password', $password, ['class' => 'form-control'.($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Password']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('password') }}
        </div>    
    </div>    
</div>
<div class="form-group row">
    <div class="col-sm-12 col-md-6">
        {!! Form::label('mobile', 'Mobile :') !!}       
        {!! Form::text('mobile', null, ['class' => 'form-control'.($errors->has('mobile') ? ' is-invalid' : ''), 'placeholder' => 'Mobile']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('mobile') }}
        </div>    
    </div>  
    <div class="col-sm-12 col-md-6">
        {!! Form::label('status', 'Status * :') !!}       
        {!! Form::select('status', [0 => 'Inactive', 1 => 'Active'], null, ['class' => 'form-control'.($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => '--- Select Status ---', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('status') }}
        </div>    
    </div>    
</div>
<div class="form-group row">
    <div class="col-sm-12 col-md-6">
        {!! Form::label('referral_code', 'Referral Code :') !!}       
        {!! Form::text('referral_code', null, ['class' => 'form-control'.($errors->has('referral_code') ? ' is-invalid' : ''), 'placeholder' => 'Referral Code', 'readonly' => 'readonly']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('referral_code') }}
        </div>    
    </div>  
    <div class="col-sm-12 col-md-6">
        {!! Form::label('referral_by', 'Referral By :') !!}       
        {!! Form::text('referral_by', null, ['class' => 'form-control'.($errors->has('referral_by') ? ' is-invalid' : ''), 'placeholder' => 'Referral By']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('referral_by') }}
        </div>    
    </div>    
</div>
<div class="form-group row">
    <div class="col-sm-12 col-md-12">
        <blockquote class="blockquote mb-0">
            <p class="mb-0">Address Details: </p>
        </blockquote>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-12 col-md-6">
        {!! Form::label('street_address', 'Street Address * :') !!}       
        {!! Form::text('street_address', null, ['class' => 'form-control'.($errors->has('street_address') ? ' is-invalid' : ''), 'placeholder' => 'Street Address', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('street_address') }}
        </div>    
    </div>  
    <div class="col-sm-12 col-md-6">
        {!! Form::label('city', 'City * :') !!}       
        {!! Form::text('city', null, ['class' => 'form-control'.($errors->has('city') ? ' is-invalid' : ''), 'placeholder' => 'City', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('city') }}
        </div>    
    </div>    
</div>
<div class="form-group row">
    <div class="col-sm-12 col-md-6">
        {!! Form::label('provience', 'Provience * :') !!}       
        {!! Form::select('provience', $provinces, null, ['class' => 'form-control'.($errors->has('provience') ? ' is-invalid' : ''), 'placeholder' => '--- Select Provience ---', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('provience') }}
        </div>    
    </div>  
    <div class="col-sm-12 col-md-6">
        {!! Form::label('postal_code', 'Postal Code * :') !!}       
        {!! Form::text('postal_code', null, ['class' => 'form-control'.($errors->has('postal_code') ? ' is-invalid' : ''), 'placeholder' => 'Postal Code', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('postal_code') }}
        </div>    
    </div>    
</div>
{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
<a href="{{ action('Admin\MemberController@index') }}" class="btn btn-primary">Cancel</a>
@section('scripts')

@endsection   



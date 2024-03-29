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
{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
<a href="{{ action('Admin\AdminController@index') }}" class="btn btn-primary">Cancel</a>
@section('scripts')

@endsection   



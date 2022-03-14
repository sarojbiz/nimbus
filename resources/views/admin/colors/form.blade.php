<div class="form-group">
    {!! Form::label('name', 'Color Name * :') !!}       
    {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('name') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('description', 'Description :') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control'.($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('description') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label('status', 'Status * :') !!}       
    {!! Form::select('status', [0 => 'Inactive', 1 => 'Active'], null, ['class' => 'form-control'.($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => '--- Select Status ---', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('status') }}
    </div>    
</div>
{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
<a href="{{ action('Admin\ColorController@index') }}" class="btn btn-primary">Cancel</a>
@section('scripts')

@endsection   



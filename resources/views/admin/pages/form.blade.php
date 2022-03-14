<div class="form-group">
    {!! Form::label('name', 'Title * :') !!}       
    {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('name') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('description', 'Content * :') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control'.($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Content', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('description') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label(null, 'Feature Image :') !!}    
    <div id="image-preview" class="image-preview">
        {!! Form::label('image-upload', 'Feature Image', ['class' => 'image-label', 'id' =>
        'image-label'])!!}
        {!! Form::file('image', ['class' => 'form-control-file image-upload', 'id' => 'image-upload', 'accept' => 'image/*']); !!}
    </div>
    <p><small>Recommended Size: 800 X 800</small></p>
    <div class="invalid-feedback{{($errors->has('image') ? ' d-block' : '')}}">
        {{ $errors->first('image') }}
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
<a href="{{ action('Admin\PageController@index') }}" class="btn btn-primary">Cancel</a>
@section('scripts')
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>
    CKEDITOR.replace( 'description' );
    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
        });
        
        @isset($page)
        $("#image-preview")
            .css('background', 'url({{ $page->image ? action('Admin\UploadController@getFile', ['file_path' => $page->image, 'assetType' => 'page_thumb']) : "" }})')
            .css('background-size', 'cover')
            .css('background-position', 'center center');
        @endisset

    });
</script>
@endsection   



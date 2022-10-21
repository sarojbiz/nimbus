<div class="form-group">
    {!! Form::label('title', 'Banner Title * :') !!}       
    {!! Form::text('title', null, ['class' => 'form-control'.($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('title') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('description', 'Banner Description :') !!}       
    {!! Form::textarea('description', null, ['class' => 'form-control'.($errors->has('tdescriptionitle') ? ' is-invalid' : ''), 'placeholder' => 'Description']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('description') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('anchor_label', 'Banner Label :') !!}       
    {!! Form::text('anchor_label', null, ['class' => 'form-control'.($errors->has('anchor_label') ? ' is-invalid' : ''), 'placeholder' => 'Banner Label']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('anchor_label') }}
    </div>    
    <p><small>Text label to show on link.</small></p>
</div>
<div class="form-group">
    {!! Form::label('anchor', 'Banner Link :') !!}       
    {!! Form::url('anchor', null, ['class' => 'form-control'.($errors->has('anchor') ? ' is-invalid' : ''), 'placeholder' => 'Banner Link']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('anchor') }}
    </div>    
    <p><small>Link including : https or https://</small></p>
</div>
<div class="form-group">
    {!! Form::label(null, 'Banner * :') !!}    
    <div id="image-preview" class="image-preview">
        {!! Form::label('image-upload', 'Banner', ['class' => 'image-label', 'id' =>
        'image-label'])!!}
        {!! Form::file('image', ['class' => 'form-control-file image-upload', 'id' => 'image-upload', 'accept' => 'image/*']); !!}
    </div>
    <p><small>Recommended Size: 950 X 400</small></p>
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
<a href="{{ action('Admin\BannerController@index') }}" class="btn btn-primary">Cancel</a>
@section('scripts')
<script>
    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
        });
        
        @isset($banner)
        $("#image-preview")
            .css('background', 'url({{ $banner->image ? action('Admin\UploadController@getFile', ['file_path' => $banner->image, 'assetType' => 'banner_thumb']) : "" }})')
            .css('background-size', 'cover')
            .css('background-position', 'center center');
        @endisset

    });
</script>
@endsection   



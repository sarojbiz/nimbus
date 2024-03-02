<div class="form-group">
    {!! Form::label('category_name', 'Category Name * :') !!}       
    {!! Form::text('category_name', null, ['class' => 'form-control'.($errors->has('category_name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('category_name') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('parent_category_id', 'Parent Category :') !!}    
    {!! Form::select('parent_category_id', $categories, null,
    ['class' => 'form-control basic-single'.($errors->has('parent_category_id') ? ' is-invalid' : ''),
    'placeholder' => '--- Select Parent Category ---']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('parent_category_id') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('category_description', 'Description :') !!}
    {!! Form::textarea('category_description', null, ['class' => 'form-control'.($errors->has('category_description') ? ' is-invalid' : ''), 'placeholder' => 'Description']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('category_description') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label('category_level', 'Level * :') !!}       
    {!! Form::selectRange('category_level', 1, 10, null, ['class' => 'form-control'.($errors->has('category_level') ? ' is-invalid' : ''), 'placeholder' => '--- Level ---', 'min' => 1, 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('category_level') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('menu_item', 'Show in Menu * :') !!}       
    {!! Form::select('menu_item', [0 => 'No', 1 => 'Yes'], null, ['class' => 'form-control'.($errors->has('menu_item') ? ' is-invalid' : ''), 'placeholder' => '--- Show in Menu ---', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('menu_item') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label('status', 'Status * :') !!}       
    {!! Form::select('status', $categoryStatuses, null, ['class' => 'form-control'.($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => '--- Select Status ---', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('status') }}
    </div>    
</div>
<div class="form-group">
    {!! Form::label(null, 'Image * :') !!}    
    <div id="image-preview" class="image-preview">
        {!! Form::label('image-upload', 'Category Image', ['class' => 'image-label', 'id' =>
        'image-label'])!!}
        {!! Form::file('category_image', ['class' => 'form-control-file image-upload', 'id' => 'image-upload', 'accept' => 'image/*']); !!}
    </div>
    <p><small>Recommended Size: 800 X 800</small></p>
    <div class="invalid-feedback{{($errors->has('category_image') ? ' d-block' : '')}}">
        {{ $errors->first('category_image') }}
    </div>
</div>
{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
<a href="{{ action('Admin\CategoryController@index') }}" class="btn btn-primary">Cancel</a>
@section('scripts')
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>    
    CKEDITOR.replace( 'category_description' );
    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
        });

        
        @isset($category)
        $("#image-preview")
            .css('background', 'url({{ $category->category_image ? action('Admin\UploadController@getFile', ['file_path' => $category->category_image, 'assetType' => 'category_thumb']) : "" }})')
            .css('background-size', 'cover')
            .css('background-position', 'center center');
        @endisset

    });
</script>
@endsection   



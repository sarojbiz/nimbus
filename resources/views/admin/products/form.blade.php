<div class="row">
<div class="col-lg-6">    
    <div class="form-group">
        {!! Form::label('pdt_name', 'Name * :') !!}       
        {!! Form::text('pdt_name', null, ['class' => 'form-control'.($errors->has('pdt_name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('pdt_name') }}
        </div>    
    </div>    
    <div class="form-group">
        {!! Form::label('inventory_sku', 'SKU : *') !!}  
        <small>Required for Simple Product Type</small>        
        {!! Form::text('inventory_sku', optional($product->inventorySimpleProduct)->inventory_sku, ['class' => 'form-control'.($errors->has('inventory_sku') ? ' is-invalid' : ''), 'placeholder' => 'SKU', $product->required]) !!}
        <div class="invalid-feedback">
            {{ $errors->first('inventory_sku') }}
        </div>    
    </div> 
    <div class="form-group">
        {!! Form::label('pdt_brand', 'Brand * : ') !!}            
        {!! Form::select('pdt_brand', $brands, null,
        ['class' => 'form-control basic-single'.($errors->has('pdt_brand') ? ' is-invalid' : ''),
        'placeholder' => '--- Select Brand ---', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('pdt_brand') }}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('regular_price', 'Regular Price * :') !!}   
        <small>Required for Simple Product Type</small>   
        {!! Form::number('regular_price', optional($product->inventorySimpleProduct)->regular_price, ['class' => 'form-control'.($errors->has('regular_price') ? ' is-invalid' : ''), 'placeholder' => 'Price', 'step' => 'any', $product->required]) !!}
        <div class="invalid-feedback">
            {{ $errors->first('regular_price') }}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('is_sale_product', 'Sales Product * :') !!}       
        {!! Form::select('is_sale_product', [0 => 'No', 1 => 'Yes'], NULL, ['class' => 'form-control'.($errors->has('is_sale_product') ? ' is-invalid' : ''), 'placeholder' => '--- Is Sales Product ---', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('is_sale_product') }}
        </div>    
    </div> 
</div>
<div class="col-lg-6">  
    <div class="form-group">
        {!! Form::label('has_size_color', 'Product Type * :') !!}       
        {!! Form::select('has_size_color', $productTypes, null, ['class' => 'form-control'.($errors->has('has_size_color') ? ' is-invalid' : ''), 'placeholder' => '--- Product Type ---', $product->product_type_status]) !!}
        <div class="invalid-feedback">
            {{ $errors->first('has_size_color') }}
        </div>    
    </div>        
    <div class="form-group">
        {!! Form::label('barcode', 'Barcode * :') !!}       
        <small>Required for Simple Product Type</small>   
        {!! Form::text('barcode', optional($product->inventorySimpleProduct)->barcode, ['class' => 'form-control'.($errors->has('barcode') ? ' is-invalid' : ''), 'placeholder' => 'Barcode', $product->required]) !!}
        <div class="invalid-feedback">
            {{ $errors->first('barcode') }}
        </div>    
    </div>    
    <div class="form-group">
        {!! Form::label('category_code', 'Category * :') !!}    
        {!! Form::select('category_code', $categories, null,
        ['class' => 'form-control basic-single'.($errors->has('category_code') ? ' is-invalid' : ''),
        'placeholder' => '--- Select Category ---', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('category_code') }}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('sales_price', 'Sales Price') !!}       
        {!! Form::number('sales_price', optional($product->inventorySimpleProduct)->sales_price, ['class' => 'form-control'.($errors->has('sales_price') ? ' is-invalid' : ''), 'placeholder' => 'Sales Price', 'step' => 'any']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('sales_price') }}
        </div>    
    </div>  
    <div class="form-group">
        {!! Form::label('product_status', 'Status * :') !!}       
        {!! Form::select('product_status', $statuses, null, ['class' => 'form-control'.($errors->has('product_status') ? ' is-invalid' : ''), 'placeholder' => '--- Select Status ---', 'required' => 'required']) !!}
        <div class="invalid-feedback">
            {{ $errors->first('product_status') }}
        </div>    
    </div>                        
</div>
</div>
<div class="form-group">
    {!! Form::label('pdt_short_description', 'Short Description * :') !!}
    {!! Form::textarea('pdt_short_description', null, ['class' => 'form-control'.($errors->has('pdt_short_description') ? ' is-invalid' : ''), 'placeholder' => 'Short Description', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('pdt_short_description') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label('pdt_long_description', 'Brief Description * :') !!}
    {!! Form::textarea('pdt_long_description', null, ['class' => 'form-control'.($errors->has('pdt_long_description') ? ' is-invalid' : ''), 'placeholder' => 'Brief Description', 'required' => 'required']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('pdt_long_description') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ingredients', 'Ingredients :') !!}
    {!! Form::textarea('ingredients', null, ['class' => 'form-control'.($errors->has('ingredients') ? ' is-invalid' : ''), 'placeholder' => 'Ingredients']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('ingredients') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label('how_to_us', 'How To Use :') !!}
    {!! Form::textarea('how_to_us', null, ['class' => 'form-control'.($errors->has('how_to_us') ? ' is-invalid' : ''), 'placeholder' => 'How To Use']) !!}
    <div class="invalid-feedback">
        {{ $errors->first('how_to_us') }}
    </div>
</div>
<div class="form-group">
    {!! Form::label(null, 'Product Image * :') !!}    
    <div id="image-preview" class="image-preview">
        {!! Form::label('image-upload', 'Product Image', ['class' => 'image-label', 'id' =>
        'image-label'])!!}
        {!! Form::file('feature_image', ['class' => 'form-control-file image-upload', 'id' => 'image-upload', 'accept' => 'image/*']); !!}
    </div>
    <p><small>Recommended Size: 800 X 800</small></p>
    <div class="invalid-feedback{{($errors->has('feature_image') ? ' d-block' : '')}}">
        {{ $errors->first('feature_image') }}
    </div>
</div> 
<div class="row">    
    <table name="product_attributes" id="product_attributes" style="display:{{((isset($product) && $product->has_size_color == 1) || old('has_size_color') == 1 ) ? 'show' : 'none'}};">  
        <thead>
            <tr>
                <th>{!! Form::label('header_size', 'Size :') !!}</th>
                <th>{!! Form::label('header_color', 'Color :') !!}</th>
                <th>{!! Form::label('header_regular_price', 'Regular Price * :') !!}</th>
                <th>{!! Form::label('header_sales_price', 'Sales Price :') !!}</th>
                <th>{!! Form::label('header_inventory_sku', 'SKU * :') !!}</th>
                <th>{!! Form::label('header_barcode', 'Barcode * :') !!}</th>
                <th>&nbsp;<span class="float-right" id="clone_plus" style="cursor:pointer;"><i class="fas fa-plus-square"></i></th>            
            </tr>
        </thead>
    <tbody>
        {{-- old invetory render for product edit --}}  
        @if( isset($product->inventoryProducts) )
        @forelse( $product->inventoryProducts as $key => $attribute )
            <tr>
            <td>  
                {!! Form::select('attribute['. $key .'][size]', $sizes, $attribute->size_id, ['class' => 'form-control'.($errors->has('attribute.'. $key .'.size') ? ' is-invalid' : ''), 'placeholder' => '--- Select Size ---']) !!}
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.'. $key .'.size') }}
                </div>                 
            </td>
            <td>
                {!! Form::select('attribute['. $key .'][color]', $colors, $attribute->color_id, ['class' => 'form-control'.($errors->has('attribute.'. $key .'.color') ? ' is-invalid' : ''), 'placeholder' => '--- Select Color ---']) !!}
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.'. $key .'.color') }}
                </div>                 
            </td>
            <td>
                {!! Form::number('attribute['. $key .'][regular_price]', $attribute->regular_price, ['class' => 'form-control'.($errors->has('attribute.'. $key .'.regular_price') ? ' is-invalid' : ''), 'placeholder' => 'Regular Price', 'step' => 'any']) !!}    
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.'. $key .'.regular_price') }}
                </div>            
            </td>
            <td>
                {!! Form::number('attribute['. $key .'][sales_price]', $attribute->sales_price, ['class' => 'form-control'.($errors->has('attribute.'. $key .'.sales_price') ? ' is-invalid' : ''), 'placeholder' => 'Sales Price', 'step' => 'any']) !!}  
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.'. $key .'.sales_price') }}
                </div>               
            </td>
            <td>  
                {!! Form::text('attribute['. $key .'][inventory_sku]', $attribute->inventory_sku, ['class' => 'form-control'.($errors->has('attribute.'. $key .'.inventory_sku') ? ' is-invalid' : ''), 'placeholder' => 'SKU']) !!}  
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.'. $key .'.inventory_sku') }}
                </div>          
            </td>
            <td>
                {!! Form::text('attribute[' . $key . '][barcode]', $attribute->barcode, ['class' => 'form-control'.($errors->has('attribute.'. $key .'.barcode') ? ' is-invalid' : ''), 'placeholder' => 'Barcode']) !!} 
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.'. $key .'.barcode') }}
                </div>                   
            </td> 
            <td> <span class="float-right clone_minus" style="cursor:pointer;"><i class="fas fa-minus-square" data-id={{$attribute->id}}></i></span><inut type="hidden" name="attribute[{{ $key }}][attribute_id]" class="attribute_id" value="{{$attribute->id}}" /></td>
            </tr> 
            {{-- old invetory render for product edit ends --}} 
        @empty  
            @if(old('attribute') !== NULL && !empty(old('attribute')))          
                @foreach( old('attribute') as $key => $attribute )
                    <tr>
                    <td>   
                        {!! Form::select('attribute['. $key .'][size]', $sizes, $attribute['size'], ['class' => 'form-control'.($errors->has('attribute.'. $key .'.size') ? ' is-invalid' : ''), 'placeholder' => '--- Select Size ---']) !!}
                        <div class="invalid-feedback">
                            {{ $errors->first('attribute.'. $key .'.size') }}
                        </div>                 
                    </td>
                    <td>
                        {!! Form::select('attribute['. $key .'][color]', $colors, $attribute['color'], ['class' => 'form-control'.($errors->has('attribute.'. $key .'.color') ? ' is-invalid' : ''), 'placeholder' => '--- Select Color ---']) !!}
                        <div class="invalid-feedback">
                            {{ $errors->first('attribute.'. $key .'.color') }}
                        </div>                 
                    </td>
                    <td>
                        {!! Form::number('attribute['. $key .'][regular_price]', $attribute['regular_price'], ['class' => 'form-control'.($errors->has('attribute.'. $key .'.regular_price') ? ' is-invalid' : ''), 'placeholder' => 'Regular Price', 'step' => 'any']) !!}  
                        <div class="invalid-feedback">
                            {{ $errors->first('attribute.'. $key .'.regular_price') }}
                        </div>              
                    </td>
                    <td>
                        {!! Form::number('attribute['. $key .'][sales_price]', $attribute['sales_price'], ['class' => 'form-control'.($errors->has('attribute.'. $key .'.sales_price') ? ' is-invalid' : ''), 'placeholder' => 'Sales Price', 'step' => 'any']) !!} 
                        <div class="invalid-feedback">
                            {{ $errors->first('attribute.'. $key .'.sales_price') }}
                        </div>               
                    </td>
                    <td>  
                        {!! Form::text('attribute['. $key .'][inventory_sku]', $attribute['inventory_sku'], ['class' => 'form-control'.($errors->has('attribute.'. $key .'.inventory_sku') ? ' is-invalid' : ''), 'placeholder' => 'SKU']) !!}  
                        <div class="invalid-feedback">
                            {{ $errors->first('attribute.'. $key .'.inventory_sku') }}
                        </div>         
                    </td>
                    <td>
                        {!! Form::text('attribute[' . $key . '][barcode]', $attribute['barcode'], ['class' => 'form-control'.($errors->has('attribute.'. $key .'.barcode') ? ' is-invalid' : ''), 'placeholder' => 'Barcode']) !!}   
                        <div class="invalid-feedback">
                            {{ $errors->first('attribute.'. $key .'.barcode') }}
                        </div>               
                    </td> 
                    <td> <span class="float-right clone_minus" style="cursor:pointer;"><i class="fas fa-minus-square" data-id=0></i></td>
                    </tr>
                @endforeach
            @else
            <tr>
            <td>   
                {!! Form::select('attribute[0][size]', $sizes, null, ['class' => 'form-control'.($errors->has('attribute.0.size') ? ' is-invalid' : ''), 'placeholder' => '--- Select Size ---']) !!}
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.0.size') }}
                </div>                 
            </td>
            <td>
                {!! Form::select('attribute[0][color]', $colors, null, ['class' => 'form-control'.($errors->has('attribute.0.color') ? ' is-invalid' : ''), 'placeholder' => '--- Select Color ---']) !!}
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.0.color') }}
                </div>                 
            </td>
            <td>
                {!! Form::number('attribute[0][regular_price]', NULL, ['class' => 'form-control'.($errors->has('attribute.0.regular_price') ? ' is-invalid' : ''), 'placeholder' => 'Regular Price', 'step' => 'any']) !!} 
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.0.regular_price') }}
                </div>               
            </td>
            <td>
                {!! Form::number('attribute[0][sales_price]', NULL, ['class' => 'form-control'.($errors->has('attribute.0.sales_price') ? ' is-invalid' : ''), 'placeholder' => 'Sales Price', 'step' => 'any']) !!}  
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.0.sales_price') }}
                </div>              
            </td>
            <td>  
                {!! Form::text('attribute[0][inventory_sku]', NULL, ['class' => 'form-control'.($errors->has('attribute.0.inventory_sku') ? ' is-invalid' : ''), 'placeholder' => 'SKU']) !!}   
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.0.inventory_sku') }}
                </div>        
            </td>
            <td>
                {!! Form::text('attribute[0][barcode]', NULL, ['class' => 'form-control'.($errors->has('attribute.0.barcode') ? ' is-invalid' : ''), 'placeholder' => 'Barcode']) 
                !!}                  
                <div class="invalid-feedback">
                    {{ $errors->first('attribute.0.barcode') }}
                </div>
            </td> 
            <td> <span class="float-right clone_minus" style="cursor:pointer;"><i class="fas fa-minus-square" data-id=0></i></span></td>
            </tr> 
            @endif 
        @endforelse 
        @endif 
    </tbody>
    <tfoot>
        <tr><td colspan="6">&nbsp;</td></tr>
    </tfoot>
</table>           
</div>
{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
<a href="{{ action('Admin\ProductController@index') }}" class="btn btn-primary">Back</a>
@section('scripts')
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>
    function deleteSingleItinary( _this, _iid ){
        if( _iid <= 0 ){
            return false;
        }
        var _btn = _this,
            _data = {'id' : _iid, '_token': "{{ csrf_token() }}"},
            _url = "{{action('Admin\ProductController@deleteSingleInventory', ['product' => $product])}}",
            _beforeCb = function(){
                //_btn.hide();                
                //_btn.next('.loading').show();
            },
            _successCb = function(result){
                //_btn.next('.loading').hide();
                //_btn.show();        
                if(result.response){
                    _this.parents('tr').remove();
                }
                alert(result.message);
            };
        ajax_process_callbacks(_data, _url, _beforeCb, _successCb);	
    }
    function _toggleRequiredStatus(required = true){
        var _fields = ['inventory_sku', 'barcode', 'regular_price'];
        _fields.forEach(function( value ) {
            $("input[name='"+ value +"']").prop('required', required);
        })
    }
    function _toggleRequiredInventoryStatus(required = true){
        var _table = $('#product_attributes');
        _table.find('tbody tr').each(function(){
            $(this).find('td:gt(1)').find(':input').prop('required', required);
        })
    }
    CKEDITOR.replace( 'pdt_long_description' );
    CKEDITOR.replace( 'ingredients' );
    CKEDITOR.replace( 'how_to_us' );
    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
        });
        
        @isset($product)
        $("#image-preview")
            .css('background', 'url({{ $product->feature_image ? action('Admin\UploadController@getFile', ['file_path' => $product->feature_image, 'assetType' => 'product_thumb']) : "" }})')
            .css('background-size', 'cover')
            .css('background-position', 'center center');
        @endisset

        $('#clone_plus').on('click', function(){
            var _count = $('#product_attributes tbody tr').length,
                _html = $('#product_attributes tbody tr:last').clone(),
                _appendHTML = '<tr>' + _html.html() + '</tr>';
            $('#product_attributes tbody').append( _appendHTML );
            $('#product_attributes tbody tr:last').find(':input').val('');

            $('#product_attributes tbody tr:last td:eq(0)').find(':input').attr("name", "attribute[" + _count + "][size]");
            $('#product_attributes tbody tr:last td:eq(1)').find(':input').attr("name", "attribute[" + _count + "][color]");
            $('#product_attributes tbody tr:last td:eq(2)').find(':input').attr("name", "attribute[" + _count + "][regular_price]");
            $('#product_attributes tbody tr:last td:eq(3)').find(':input').attr("name", "attribute[" + _count + "][sales_price]");
            $('#product_attributes tbody tr:last td:eq(4)').find(':input').attr("name", "attribute[" + _count + "][inventory_sku]");
            $('#product_attributes tbody tr:last td:eq(5)').find(':input').attr("name", "attribute[" + _count + "][barcode]");
            $('#product_attributes tbody tr:last td:last').find('.attribute_id').attr("name", "attribute[" + _count + "][attribute_id]");
            $('#product_attributes tbody tr:last td:last').find('.clone_minus .fa-minus-square').attr("data-id", 0);
            $('#product_attributes tbody tr:last td:last').find('.attribute_id').remove();
        })

        $('#has_size_color').on('change', function(){
            if($(this).val() == 1) {
                _toggleRequiredStatus(false);
                _toggleRequiredInventoryStatus(true);
                $('#product_attributes').show();
            }else{
                _toggleRequiredStatus(true);
                _toggleRequiredInventoryStatus(false);
                $('#product_attributes').hide();
            }
        })

        $(document).on( 'click', '.fa-minus-square', function(){
            var _this = $(this),
                _delete = true,
                _iid = _this.data('id');            
            if(confirm('Are you sure to delete this row?')){
                //check for variation id
                var _itinarys = $('#product_attributes').find('tbody tr').length;
                if(_itinarys <= 1){
                    alert('Atleast one itinary is required for variable product.');
                    return false;
                }
                if( _iid ){
                    deleteSingleItinary( _this, _iid );                    
                }else{
                    _this.parents('tr').remove();
                }
            }
        })
    });
</script>
@endsection   
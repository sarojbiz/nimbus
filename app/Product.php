<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Enums\GeneralStatus;
use App\InventoryProduct;

class Product extends Model
{
    protected $primaryKey = 'pdt_id';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'has_size_color' => 'integer',
        'is_feature_product' => 'boolean',
        'is_sale_product' => 'boolean',        
    ];

	protected $fillable = [
        'pdt_id','mcode', 'pdt_code', 'pdt_name', 'pdt_short_description', 'pdt_long_description','category_code', 'pdt_brand', 'measurement_unit', 'has_size_color', 'is_feature_product', 'is_sale_product', 'product_status', 'feature_image', 'gallery_images', 'created_by', 'updated_by'
    ];	 

    public function scopeExclude($query, $value = array()) 
    {
        return $query->select( array_diff( $this->fillable,(array) $value) );
    }    

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'pdt_brand', 'id');
    }
    
    public function parent()
    {
        return $this->belongsTo('App\Category', 'category_code', 'category_id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id');
    }

    /**
     * get product details from product id.
     * return product detail, attributes and custom acutal price.
     * 
     * @return array
     */
    public static function getInventory($request)
    {
        $inventoryProduct = [];
        //get product details from product id
        $product = Product::where(['pdt_id' => $request->get('pdt_id'), 'product_status' => GeneralStatus::Enabled])->first();
        if( is_null( $product )){
            return NULL;
        }
        
        if ($product->has_size_color) {            
            $inventoryProduct = InventoryProduct::where(function($query) use($request){
                $query->where('product_id', $request->get('pdt_id'));

                if($request->get('size')){
                    $query->where('size_id', $request->get('size'));
                }
                if($request->get('color')){
                    $query->where('color_id', $request->get('color'));
                }                
            })->first();
        }else{
            $inventoryProduct = InventoryProduct::where('product_id', $request->get('pdt_id'))->first();                       
        }
       
        if( $inventoryProduct ){
            $inventoryProduct->actual_price = $inventoryProduct->sales_price ? round($inventoryProduct->sales_price, 2) : round($inventoryProduct->regular_price, 2);
        
            //add produc details as well so that we can use product details
            $inventoryProduct->product = $product;
        }      
        
        return $inventoryProduct;
    }
    
    /**
     * return price of any product
     * return regular and sales prices
     * 
     * @return string
     */
    public function getShowPriceAttribute()
    {
        $return = '';
        if ($this->attributes['has_size_color']) {
            //since its variable product, so no need to show price.
            $return = ''; 
        }else{
            $inventoryProduct = InventoryProduct::where('product_id', $this->attributes['pdt_id'])->first();
            if( $inventoryProduct ){
                if ( $inventoryProduct->sales_price ) {
                    $return = '<span class="old">Rs. '.number_format($inventoryProduct->regular_price, 2).'</span> <span>Rs. '.number_format($inventoryProduct->sales_price, 2).'</span>';
                } else {
                    $return = '<span>Rs. '.number_format($inventoryProduct->regular_price, 2).'</span>';
                }
            }            
        }
        return $return;                       
    }  

    /**
     * return true if simple product
     * 
     * @return string
     */
    public function getSimpleProductAttribute()
    {
        return $this->attributes['has_size_color'] ? false : true;                      
    }

    /**
     * return true if variable product 
     * 
     * @return string
     */
    public function getVariableProductAttribute()
    {
        return $this->attributes['has_size_color'];                      
    }

    /**
     * Get the inventorys of associated with the product.
     */
    public function inventorySimpleProduct()
    {
        return $this->hasOne('App\InventoryProduct', 'product_id', 'pdt_id')->whereNull(['size_id','color_id']);
    }
    
    /**
     * Get the inventorys of associated with the product.
     */
    public function inventoryProducts()
    {
        return $this->hasMany('App\InventoryProduct', 'product_id', 'pdt_id')->orderBy('size_id', 'ASC')->orderBy('color_id', 'ASC');
    }

    /**
     * Get the size attribute associated with the product.
     * this will give size attribute only
     */
    public function sizes()
    {
        return $this->belongsToMany('App\Size', 'inventory_products', 'product_id', 'size_id')->orderBy('size_id');
    }

    /**
     * Get the color attribute associated with the product.
     * this will give color attribute only
     */
    public function colors()
    {
        return $this->belongsToMany('App\Color', 'inventory_products', 'product_id', 'color_id')->orderBy('color_id');
    }
}

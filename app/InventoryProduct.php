<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryProduct extends Model
{
    protected $appends = array('discount');

    /**
     * Returns discount if we have sales price of a product
     * access using discount variable
     * @return bool
     */
    public function getDiscountAttribute()
    {
        if($this->attributes['sales_price'] && ($this->attributes['sales_price'] < $this->attributes['regular_price'])) {
            return round(($this->attributes['regular_price'] - $this->attributes['sales_price']), 2);
        }
        return 0.00;
    }

    /**
     * Get the size attribute associated with the product.
     * this will give size attribute only
     */
    public function size()
    {
        return $this->belongsTo('App\Size');
    }

    /**
     * Get the color attribute associated with the product.
     * this will give color attribute only
     */
    public function color()
    {
        return $this->belongsTo('App\Color');
    }    
}

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
}

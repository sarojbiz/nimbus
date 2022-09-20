<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public $timestamps = false;

    /**
     * Get the inventorys of associated with the product.
     */
    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id', 'pdt_id');
    }
}

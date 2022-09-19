<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public $timestamps = false;

    /**
     * Get the inventorys of associated with the product.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the inventorys of associated with the product.
     */
    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct', 'order_id', 'id');
    }
}

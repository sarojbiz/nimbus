<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the order items associated with order
     */
    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }
}

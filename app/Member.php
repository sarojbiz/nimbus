<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'users';

    /**
     * Get the full name of delivery person
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Get the orders associated with delivery person
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'street_address', 'city', 'provience', 'postal_code', 'country', 'is_default', 'user_id'
    ];
}

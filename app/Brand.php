<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'image', 'slug', 'status', 'created_at', 'updated_at'
    ]; 

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'pdt_brand', 'id');        
    } 
}

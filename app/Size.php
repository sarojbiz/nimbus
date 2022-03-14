<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'status', 'created_at', 'updated_at'
    ]; 

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id');
    }

    /**
     * Get the values associated with attribute
     */
    public function sizeDropDown()
    {
        return $this->hasMany('App\Size')->orderBy('name')->select(['id', 'name']);
    }
    
}

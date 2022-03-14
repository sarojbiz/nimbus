<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
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
    public function colorDropDown()
    {
        return $this->hasMany('App\Color')->orderBy('name')->select(['id', 'name']);
    }
    
}
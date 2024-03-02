<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';   
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'menu_item' => 'boolean'        
    ];
    	
	protected $fillable = [
        'category_id', 'category_name', 'parent_category_id', 'category_image', 'category_description', 'category_level', 'category_type', 'created_by', 'updated_by', 'category_slug'
    ]; 

    public function scopeExclude($query, $value = array()) 
    {
        return $query->select( array_diff( $this->fillable,(array) $value) );
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_category_id', 'category_id');
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
    return $this->children()->with('childrenRecursive');
    // which is equivalent to:
    // return $this->hasMany('Survey', 'parent')->with('childrenRecursive);
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_category_id', 'category_id');
    }   
    
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
        return $this->hasMany(Product::class, 'category_code', 'category_id')->where('status', 1);        
    }   

    /**
     * Get the full address of vendor
     *
     * @return string
     */
    public function getShowMenuLabelAttribute()
    {
        return $this->attributes['menu_item'] ? 'Yes' : 'No';
    }
}

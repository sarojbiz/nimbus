<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $primaryKey = 'barcode_id';

	protected $fillable = [
        'barcode_id', 'barcode', 'pdt_code', 'color_id', 'size_code', 'price', 'created_by', 'created_at', 'updated_by', 'updated_at'
    ];	 

    public function scopeExclude($query, $value = array()) 
    {
        return $query->select( array_diff( $this->fillable,(array) $value) );
    }     
    
    public function colors()
	{
		return $this->hasMany('App\Color','color_id','color_id');
    } 
    
    public function hasColor($color_name)
	{
		if($this->colors()->where('name', $color_name)->first())
		{
			return true;
		}
	}
}

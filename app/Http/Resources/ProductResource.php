<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'mcode' => $this->mcode,
            'title' => $this->pdt_name,
            'slug' => $this->slug,
            'parent' => optional($this->parent)->category_name,
            'children' => NULL,
            'image' => $this->feature_image ? action('UploadController@getFile', ['product_thumb', $this->feature_image]) : null,
            'type' => $this->has_size_color ? 'Variable product' : 'Simple product',
            'brand' => optional($this->brand)->name,
            'sales_product' => $this->is_sales_product ? 'Yes' : 'No',
            'status' => GeneralStatus::fromValue((int) $this->status)->description,    
            //'size' => Size::where('id', $this->inventoryProducts->size_id)->pluck('name')->first(),
            //'color' => Color::where('id', $this->inventoryProducts->color_id)->pluck('name')->first(),  
            //'inventory_sku' => $this->inventoryProducts->inventory_sku,
            //'barcode' => $this->inventoryProducts->barcode,      
            //'original_price' => round($this->inventoryProducts->regular_price, 2),
            //'price' => round($this->inventoryProducts->sales_price, 2),
            'discount' => NULL,
            'unit' => NULL,
            'quantity' => 100,
            'tag' => optional($this->parent)->category_name,
            'description' => strip_tags($this->short_description)
        ];
    }
}

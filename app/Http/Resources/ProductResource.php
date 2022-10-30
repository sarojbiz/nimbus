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
            'id'    => $this->pdt_id,
            'mcode' => $this->mcode,
            'title' => $this->pdt_name,
            'slug' => $this->slug,
            'parent' => optional($this->parent)->category_name,
            'children' => NULL,
            'image' => $this->feature_image ? action('UploadController@getFile', ['product_thumb', $this->feature_image]) : null,
            'type' => $this->has_size_color ? 'variable' : 'simple',
            'brand' => optional($this->brand)->name,
            'feature_product' => $this->is_feature_product,
            'sales_product' => $this->is_sales_product,
            'stock_status' => $this->stock_status,
            'status' => GeneralStatus::fromValue((int) $this->product_status)->description,    
            'tag' => optional($this->parent)->category_name,
            'description' => strip_tags($this->short_description),
            'ingredients' => strip_tags($this->ingredients),
            'how_to_use' => strip_tags($this->how_to_use),
            'variations' => AttributeResource::collection($this->inventoryProducts)
        ];
    }
}
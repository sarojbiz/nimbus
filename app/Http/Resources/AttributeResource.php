<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;

class AttributeResource extends JsonResource
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
            'size' => Size::where('id', $this->size_id)->pluck('name')->first(),            
            'size_id' => $this->size_id,
            'color' => Color::where('id', $this->color_id)->pluck('name')->first(),  
            'color_id' => $this->color_id,
            'original_price' => $this->regular_price,
            'price' => $this->sales_price,
            'discount' => $this->discount,
            'inventory_sku' => $this->inventory_sku,
            'barcode' => $this->barcode,
            'quantity' => $this->quantity ? $this->quantity : 100,
            'unit' => NULL
        ];
    }
}

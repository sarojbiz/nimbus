<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'order_id'     => $this->order_id,
            'product_name' => $this->product_name,
            'price'        => round($this->price, 2),
            'quantity'     => $this->quantity,
            'subtotal'     => round($this->subtotal, 2),
            'tax'          => round($this->tax, 2),
            'total'        => round($this->total, 2),
            'color'        => $this->color_name,
            'size'         => $this->size_name,
            'image'        => $this->products->feature_image ? action('UploadController@getFile', ['product_thumb', $this->products->feature_image]) : null,
        ];
    }
}
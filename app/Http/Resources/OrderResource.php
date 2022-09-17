<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Size;
use App\Color;
use App\Enums\OrderStatus;
use App\Enums\GeneralStatus;

class OrderResource extends JsonResource
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
            'id'    => $this->id,
            'order_no' => $this->order_no,
            'total' => round($this->total, 2),
            'status' => GeneralStatus::fromValue((int) $this->product_status)->description,
            'shippping_status' => OrderStatus::fromValue((int) $this->order_status_id)->description,
            'products' => OrderProductResource::collection($this->orderProducts)
        ];
    }
}
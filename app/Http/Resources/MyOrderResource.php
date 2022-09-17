<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\OrderStatus;
use App\Enums\GeneralStatus;
use Carbon\Carbon;

class MyOrderResource extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_no' => $this->order_no,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d g:i A'),
            'total' => $this->total,
            'status' => GeneralStatus::fromValue((int) $this->status)->description,
            'shippping_status' => OrderStatus::fromValue((int) $this->order_status_id)->description,
        ];
    }
}

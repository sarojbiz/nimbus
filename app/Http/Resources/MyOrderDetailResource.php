<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\OrderStatus;
use App\Enums\GeneralStatus;
use Carbon\Carbon;

class MyOrderDetailResource extends JsonResource
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
            'order_no' => $this->order_no,
            'billing_first_name' => $this->b_first_name,
            'billing_last_name' => $this->b_last_name,
            'billing_email' => $this->b_email,
            'billing_street_address' => $this->b_street_address,
            'billing_city' => $this->b_city,
            'billing_postcode' => $this->b_postcode,
            'billing_state' => $this->b_state,
            'billing_phone' => $this->b_phone,
            'billing_country' => $this->b_country,
            'shipping_first_name' => $this->s_first_name,
            'shipping_last_name' => $this->s_last_name,
            'shipping_email' => $this->s_email,
            'shipping_street_address' => $this->s_street_address,
            'shipping_city' => $this->s_city,
            'shipping_postcode' => $this->s_postcode,
            'shipping_state' => $this->s_state,
            'shipping_phone' => $this->s_phone,
            'shipping_country' => $this->s_country,
            'total' => $this->total,
            'status' => GeneralStatus::fromValue((int) $this->status)->description,
            'shippping_status' => OrderStatus::fromValue((int) $this->order_status_id)->description,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d g:i A'),
            'user_id' => $this->user_id,
        ];
    }
}

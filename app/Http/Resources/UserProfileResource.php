<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'member_id' => $this->member_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'street_address' => $this->userAddress->street_address,
            'city' => $this->userAddress->city,
            'provience' => $this->userAddress->provience,
            'postal_code' => $this->userAddress->postal_code,
            'country' => $this->userAddress->country
        ];
    }
}

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
            'referral_code' => $this->referral_code,
            'referral_by' => $this->referral_by,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'street_address' => optional($this->userAddress)->street_address,
            'city' => optional($this->userAddress)->city,
            'provience' => optional($this->userAddress)->provience,
            'postal_code' => optional($this->userAddress)->postal_code,
            'country' => optional($this->userAddress)->country
        ];
    }
}

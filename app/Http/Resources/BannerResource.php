<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;

class BannerResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'anchor_label' => $this->anchor_label,
            'anchor_link' => $this->anchor,
            'slug' => $this->slug,
            'image' => $this->image ? action('UploadController@getFile', ['banner_large', $this->image]) : null,
            'status' => GeneralStatus::fromValue((int) $this->status)->description
        ];
    }
}
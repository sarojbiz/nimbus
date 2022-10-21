<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;

class CMSResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            $this->mergeWhen($request->requestType == 'detail', [
                'content' => $this->content,
            ]),
            'image' => $this->image ? action('UploadController@getFile', ['page_large', $this->image]) : null,
            'banner' => $this->banner ? action('UploadController@getFile', ['page_banner', $this->banner]) : null,
            'status' => GeneralStatus::fromValue((int) $this->status)->description
        ];
    }
}
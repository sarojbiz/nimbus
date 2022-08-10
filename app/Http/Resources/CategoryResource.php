<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'parent_category_id' => $this->parent_category_id,
            'category_image' => $this->category_image ? action('UploadController@getFile', ['category_thumb', $this->category_image]) : null,
            'category_description' => strip_tags($this->category_description),
            'category_level' => $this->category_level,
            $this->mergeWhen(isset($request->withchildren) && $request->withchildren == 'withchildren', [
                'children' => CategoryResource::collection($this->children)
            ]),
            $this->mergeWhen(isset($request->withproducts) && $request->withproducts == 'withproducts', [
                'products' => ProductResource::collection($this->products)
            ])
        ];
    }
}

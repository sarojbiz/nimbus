<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check Create or Update
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $imageRules = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        } else {
            $imageRules = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        }

        return [            
            'anchor' => 'sometimes|nullable|url',
            'image' => $imageRules,
            'status' => 'required',
        ];
    }
}

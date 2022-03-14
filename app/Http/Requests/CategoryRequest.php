<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
            $nameRules = 'nullable|max:255|unique:categories,category_name,' . $this->route('category')->category_id . ',category_id' ;
        } else {
            $nameRules = 'required|max:255|unique:categories,category_name';
        }
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $imageRules = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        } else {
            $imageRules = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        }

        return [
            'category_name' => $nameRules,            
            'category_level' => 'required',
            'menu_item' => 'required',
            'category_image' => $imageRules,
            'parent_category_id' => 'nullable|exists:categories,category_id',
            'status' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [            
            'parent_category_id.exists' => 'Invalid Parent Category selected.'
        ];
    }
}

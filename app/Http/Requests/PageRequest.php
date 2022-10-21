<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PageRequest extends FormRequest
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
            $nameRules = 'required|max:255|unique:pages,name,' . $this->route('page')->id;
        } else {
            $nameRules = 'required|max:255|unique:pages,name';
        }
        $imageRules = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        
        return [
            'name' => $nameRules,
            'image' => $imageRules,
            'banner' => $imageRules, 
            'description' => 'required',
            'status' => 'required',
        ];
    }
}

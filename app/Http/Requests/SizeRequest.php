<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SizeRequest extends FormRequest
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
            $nameRules = 'required|max:255|unique:sizes,name,' . $this->route('size')->id;
        } else {
            $nameRules = 'required|max:255|unique:sizes,name';
        }

        return [
            'name' => $nameRules,            
            'status' => 'required',
        ];
    }
}

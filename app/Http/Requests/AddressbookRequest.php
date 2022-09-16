<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Enums\ProvinceType;
use App\Enums\Countries;

class AddressbookRequest extends FormRequest
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
        return [
            'street_address' => 'required|max:255',
            'city' => 'required|max:255',
            'postal_code' => 'required|max:6',
            'provience' => 'required|max:6|enum_value:' . ProvinceType::class . ',false',
            'country' => 'required|enum_value:' . Countries::class . ',false',
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
            'street_address.required' => 'Street address is required.',
        ];
    }
}

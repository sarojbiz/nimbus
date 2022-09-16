<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CheckoutRequest extends FormRequest
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
            'shipping_fname' => 'required',   
            'shipping_lname' => 'required',
            'shipping_email' => 'email|required',
            'shipping_street_address' => 'required',
            'shipping_city' => 'required',
            'shipping_postal_code' => 'required',
            'shipping_state' => 'required',
            'shipping_phone' => 'required',
            'shipping_country' => 'required',
            'same_billing_shipping' => 'required',
            'billing_fname' => 'required_if:same_billing_shipping,0',
            'billing_lname' => 'required_if:same_billing_shipping,0',
            'billing_email' => 'required_if:same_billing_shipping,0',
            'billing_street_address' => 'required_if:same_billing_shipping,0',
            'billing_city' => 'required_if:same_billing_shipping,0',
            'billing_postal_code' => 'required_if:same_billing_shipping,0',            
            'billing_state' => 'required_if:same_billing_shipping,0',
            'billing_phone' => 'required_if:same_billing_shipping,0',
            'billing_country' => 'required_if:same_billing_shipping,0',
            'carts' => 'required|json'
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
            'same_billing_shipping.required' => 'Required with either 0 or 1',
            'billing_fname.required_if' => 'Billing first name is required.',
            'billing_lname.required_if' => 'Billing last name is required.',
            'billing_email.required_if' => 'Billing email is required.',
            'billing_street_address.required_if' => 'Billing street is required.',
            'billing_city.required_if' => 'Billing city is required.',
            'billing_postal_code.required_if' => 'Billing postal code is required.',
            'billing_state.required_if' => 'Billing state is required.',
            'billing_phone.required_if' => 'Billing phone number is required.',
            'billing_country.required_if' => 'Billing country is required.'
        ];
    }
}

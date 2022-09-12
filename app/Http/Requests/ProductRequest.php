<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
            $nameRules = 'nullable|max:255|unique:products,pdt_name,' . $this->route('product')->pdt_id . ',pdt_id';
        } else {
            $nameRules = 'required|max:255|unique:products,pdt_name';
        }
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $imageRules = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        } else {
            $imageRules = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        }
        
        $minRegularPrice = (int) $this->input('regular_price');
        $rules = [
            'pdt_name' => $nameRules,            
            'pdt_brand' => 'required|exists:brands,id',
            'regular_price' => 'nullable|required_if:has_size_color,==,0|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'sales_price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/|max:' . $minRegularPrice,
            'pdt_short_description' => 'required',
            'pdt_long_description' => 'required',
            //'inventory_sku' => 'required',
            'is_sale_product' => 'required',
            'feature_image' => $imageRules,
            'product_status' => 'required',
        ];
        /*
        if((int) $this->route('product')->has_size_color == 1) {
            //https://stackoverflow.com/questions/50694208/laravel-how-to-validate-array-index-and-values
            //$minRegularPrice = (int) $this->input('regular_price');
            $rules['attribute'] = 'array|min:1';
            $rules['attribute.*.color'] = ['required_without:attribute.*.size'];
            $rules['attribute.*.size'] = ['required_without:attribute.*.color'];
            $rules['attribute.*.regular_price'] = 'required|numeric|regex:/^\d+(\.\d{1,2})?$/';
            $rules['attribute.*.sales_price'] = 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/';
            //$rules['attribute.*.sales_price'] = 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/|max:' . $minRegularPrice;
            $rules['attribute.*.inventory_sku'] = 'required';
            $rules['attribute.*.barcode'] = 'required';
        }
        */
        
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'sales_price.max' => 'Sales price should be less than regular price.',
            //'regular_price.regex' => 'The price is invalid, only two decimal places allowed.',
            //'sales_price.regex' => 'The price is invalid, only two decimal places allowed.'
            'pdt_short_description.required' => 'The product short description is required.',
            'pdt_long_description.required' => 'The product brief description is required.',
            'attribute.*.size' => 'This field is required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MemberRequest extends FormRequest
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
            $nameRules = 'required|email|max:255|unique:users,email,' . $this->route('member')->id;
        } else {
            $nameRules = 'required|email|max:255|unique:users,email';
        }

        return [
            'email' => $nameRules,   
            'password' => 'sometimes|nullable|min:8',
            'referral_by' => 'sometimes|nullable|exists:users,referral_code',
            'first_name' => 'required',
            'last_name' => 'required',
            'status' => 'required',
        ];
    }
}

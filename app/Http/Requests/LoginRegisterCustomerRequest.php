<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRegisterCustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'mobile' => 'required|starts_with:09|digits:11',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'city_id' => 'required|exists:cities,id',
            'province_id' => 'required|exists:provinces,id',
        ];
    }
}

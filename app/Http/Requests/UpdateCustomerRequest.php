<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'filled|string|max:255',
            'mobile' => 'filled|starts_with:09|digits:11',
            'address' => 'filled|string',
            'postal_code' => 'filled|string|max:10',
            'city_id' => 'filled|exists:cities,id',
            'province_id' => 'filled|exists:provinces,id',
        ];
    }
}

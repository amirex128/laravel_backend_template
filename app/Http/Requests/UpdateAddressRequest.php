<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'title' => 'string|filled',
            'province_id' => 'numeric|exists:provinces,id|filled',
            'city_id' => 'numeric|exists:cities,id|filled',
            'address' => 'string|filled',
            'postal_code' => 'numeric|digits:10|filled',
            'mobile' => 'starts_with:09|digits:11|filled',
            'full_name' => 'string|filled',
            'lat' => 'numeric|filled',
            'long' => 'numeric|filled',
        ];
    }
}

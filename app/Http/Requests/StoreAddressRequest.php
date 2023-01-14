<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'title' => 'string|required',
            'address' => 'string|required',
            'postal_code' => 'digits:10|required',
            'mobile' => 'starts_with:09|digits:11|required',
            'full_name' => 'string|required',
            'lat' => 'numeric|filled',
            'long' => 'numeric|filled',
            'city_id' => 'numeric|exists:cities,id|required',
            'province_id' => 'numeric|exists:provinces,id|required',
        ];
    }


}

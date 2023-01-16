<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'description'=>'filled|string',
            'phone'=>'filled|starts_with:0|digits:11',
            'mobile'=>'filled|starts_with:09|digits:11',
            'telegram_id'=>'filled|string|max:255',
            'instagram_id'=>'filled|string|max:255',
            'whatsapp_id'=>'filled|string|max:255',
            'email'=>'filled|email|max:255',
            'website'=>'filled|string|max:255',
            'send_price'=>'filled|integer',
            'gallery_id'=>'filled|exists:galleries,id',
            'theme_id'=>'filled|exists:themes,id',
        ];
    }
}

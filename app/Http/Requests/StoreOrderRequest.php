<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'shop_id'=>'required|exists:shops,id',
            'discount_id'=>'filled|exists:discounts,id',
            'description'=>'filled|string',
            'order_items'=>'required|array',
            'order_items.*.product_id'=>'required|exists:products,id',
            'order_items.*.option_id'=>'filled|exists:options,id',
            'order_items.*.quantity'=>'required|integer',
        ];
    }
}

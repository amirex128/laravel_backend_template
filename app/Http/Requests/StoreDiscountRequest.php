<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            'code'=>'required|string|unique:discounts,code',
            'started_at'=>'required|date',
            'ended_at'=>'required|date',
            'count'=>'required|integer',
            'value'=>'required|integer',
            'percent'=>'required|integer',
            'type'=>'required|in:percent,amount',
            'model'=>'required|in:shop,product',
            'product_ids'=>'filled|array',
            'shop_ids'=>'filled|array',
        ];
    }
}

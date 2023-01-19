<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'code'=>'filled|string|unique:discounts,code',
            'started_at'=>'filled|date',
            'ended_at'=>'filled|date',
            'count'=>'filled|integer',
            'value'=>'filled|integer',
            'percent'=>'filled|integer',
            'status'=>'filled|boolean',
            'type'=>'filled|in:percent,amount',
            'product_ids'=>'filled|array',
            'shop_ids'=>'filled|array',
        ];
    }
}

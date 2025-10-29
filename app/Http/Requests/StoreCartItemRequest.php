<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
            'variant_id' => 'nullable|exists:product_variants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'يرجى اختيار منتج',
            'product_id.exists' => 'المنتج المحدد غير موجود',
            'quantity.required' => 'يرجى تحديد الكمية',
            'quantity.integer' => 'الكمية يجب أن تكون رقماً صحيحاً',
            'quantity.min' => 'الحد الأدنى للكمية هو 1',
            'quantity.max' => 'الحد الأقصى للكمية هو 100',
            'variant_id.exists' => 'المتغير المحدد غير موجود',
        ];
    }
}


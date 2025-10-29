<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string|max:255',
            'shipping_address.phone' => 'required|string|regex:/^[0-9+\-\s()]+$/|max:20',
            'shipping_address.address' => 'required|string|max:500',
            'shipping_address.city' => 'required|string|max:100',
            'shipping_address.region' => 'required|string|max:100',
            'shipping_address.postal_code' => 'nullable|string|max:10',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_address.required' => 'يرجى إدخال عنوان الشحن',
            'shipping_address.name.required' => 'اسم المستلم مطلوب',
            'shipping_address.phone.required' => 'رقم الجوال مطلوب',
            'shipping_address.phone.regex' => 'صيغة رقم الجوال غير صحيحة',
            'shipping_address.address.required' => 'عنوان الشحن مطلوب',
            'shipping_address.city.required' => 'المدينة مطلوبة',
            'shipping_address.region.required' => 'المنطقة مطلوبة',
            'payment_method.required' => 'يرجى اختيار طريقة الدفع',
            'payment_method.in' => 'طريقة الدفع المحددة غير صحيحة',
        ];
    }
}


<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipping_address_id' => ['required', 'exists:addresses,id'],
            'billing_address_id'  => ['nullable', 'exists:addresses,id'],
            'notes'               => ['nullable', 'string', 'max:1000'],
            'payment_method'      => ['nullable', 'string', 'max:50'],
            'coupon_code'         => ['nullable', 'string', 'exists:coupons,code'],
        ];
    }
}

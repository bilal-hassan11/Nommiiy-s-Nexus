<?php

namespace App\Http\Requests\Shop;

use App\Enums\SupplierStatus;
use Illuminate\Foundation\Http\FormRequest;

class ShopStatusUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable|in:' . implode(',', SupplierStatus::values()),
        ];
    }
}

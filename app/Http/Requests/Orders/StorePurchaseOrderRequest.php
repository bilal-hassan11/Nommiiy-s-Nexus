<?php

namespace App\Http\Requests\Orders;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePurchaseOrderRequest extends FormRequest
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
            'supplier_id' => 'nullable|exists:suppliers,id',
            'shop_id' => 'nullable|exists:shops,id',
            'payment_method' => 'required|string|in:Cash,Bank',
            'purchase_date' => 'required|date',
            'payment_status' => 'nullable|string|in:Unpaid,Paid',
            'paid_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'order_status' => 'nullable|string|in:Pending,Completed',
            'expected_delivery_date' => 'nullable|date',
            'delivery_status' => 'nullable|string|in:Pending,Delivered',
            'type' => 'nullable|string|in:Add Stock,Remove Stock,Purchase Orders,Sales Orders',
            'notes' => 'nullable|string',
            'order_details' => 'required|array|min:1',
            'order_details.*.product_id' => 'required|exists:products,id',
            'order_details.*.quantity' => 'required|numeric|min:0.01',
            'order_details.*.price' => 'required|numeric|min:0.01',
            'order_details.*.total' => 'required|numeric|min:0.01'
        ];
    }


    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

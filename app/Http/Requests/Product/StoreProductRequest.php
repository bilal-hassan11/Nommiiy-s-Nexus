<?php

namespace App\Http\Requests\Product;

use App\Rules\UniqueScoped;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Product::class, 'name', $this->name),
            ],
            "barcode" => "required|string",
            "purchase_price" => "required|integer",
            "selling_price" => "required|integer",
            "low_alert_qty" => "nullable|integer",
            "category_id" => "nullable|integer|exists:product_categories,id",
            "image" => "nullable|string",
            "description" => "nullable|string",
        ];
    }
    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

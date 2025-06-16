<?php

namespace App\Http\Requests\Discount;

use App\Enums\TaxDiscountStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Models\Discount;
use App\Rules\UniqueScoped;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiscountUpdateRequest extends FormRequest
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
        $id = $this->route('discount');
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Discount::class, 'name', $this->name, $id),
            ],
            'discount_type' => 'required|in:' . implode(',', [TaxDiscountStatus::PERCENTAGE->value, TaxDiscountStatus::FIX_AMOUNT->value]),
            'discount_value' => 'required|numeric|min:0',
        ];
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

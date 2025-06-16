<?php

namespace App\Http\Requests\Tax;

use App\Enums\TaxDiscountStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Models\Tax;
use App\Rules\UniqueScoped;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaxCreateRequest extends FormRequest
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
                new UniqueScoped(Tax::class, 'name', $this->name),
            ],
            'tax_nature' => 'required|in:' . implode(',', [TaxDiscountStatus::PERCENTAGE->value, TaxDiscountStatus::FIX_AMOUNT->value]),
            'tax_type' => 'required|in:' . implode(',', [TaxDiscountStatus::INCLUSIVE->value, TaxDiscountStatus::EXCLUSIVE->value]),
            'tax_value' => 'required',
        ];
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

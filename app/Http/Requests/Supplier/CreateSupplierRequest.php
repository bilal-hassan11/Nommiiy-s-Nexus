<?php

namespace App\Http\Requests\Supplier;

use App\Rules\UniqueScoped;
use App\Enums\SupplierStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Models\Supplier;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSupplierRequest extends FormRequest
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
    public function rules()
    {
        // Get system_user_id from request for unique name validation
        $systemUserId = $this->input('system_user_id');
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Supplier::class, 'name', $this->name),
            ],
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'status' => 'nullable'
        ];
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

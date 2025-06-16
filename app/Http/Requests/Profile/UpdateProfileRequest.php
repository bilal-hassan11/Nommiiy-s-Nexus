<?php

namespace App\Http\Requests\Profile;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
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
        $authId = auth()->id(); // Get current authenticated user ID

        return [
            'name' => [
                'sometimes', 'required', 'string', 'max:255', // Unique for current user
            ],
            'email' => [
                'sometimes', 'required', 'string', 'email', 'max:255', 'unique:users,email,' . $authId // Unique except for current user
            ],
            'contact_no' => [
                'sometimes', 'nullable', 'integer', // Optional age field validation
            ],


        ];
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

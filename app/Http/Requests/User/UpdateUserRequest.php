<?php

namespace App\Http\Requests\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user');

        return [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email," . $userId,
            "phone" => "nullable|string",
            "status" => "nullable|in:active,inactive",
            "image" => "nullable|string",
            "role_id" => "nullable|integer|exists:roles,id",
        ];
    }

    
    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

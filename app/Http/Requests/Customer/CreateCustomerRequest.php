<?php

namespace App\Http\Requests\Customer;


use App\Models\Customer;
use App\Rules\UniqueScoped;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCustomerRequest extends FormRequest
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
        // Get system_user_id from request for unique name validation

        return [

            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Customer::class, 'name', $this->name),
            ],
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'status' => 'nullable',
            'nin_bvn' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Customer::class, 'nin_bvn', $this->nin_bvn),
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

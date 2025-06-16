<?php

namespace App\Http\Requests\Customer;

use App\Models\Role;
use App\Models\Customer;
use App\Rules\UniqueScoped;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
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
        $id = $this->route('customer');
        return [

            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Customer::class, 'name', $this->name, $id),
            ],


            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'status' => 'nullable',
            'nin_bvn' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Customer::class, 'nin_bvn', $this->nin_bvn, $id),
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

<?php

namespace App\Http\Requests\Shop;

use App\Rules\UniqueScoped;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Models\Shop;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShopUpdateRequest extends FormRequest
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

        $id = $this->route('shop');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Shop::class, 'name', $this->name,$id),
            ],
            'location' => 'required|max:255',
            'contact_number' => 'nullable|string|max:15',
            'status' => 'nullable',
        ];
    }



    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value));
    }
}

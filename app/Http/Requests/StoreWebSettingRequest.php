<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true for development/API testing
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'merchant' => ['required', 'string', 'in:All,MJB,MJB2,MJB3'],
            'type' => ['required', 'string', 'in:Back Office'],
            'name' => ['required', 'string', 'in:Logo,Favicon'],
            'status' => ['required', 'string', 'in:All,Active,Inactive'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'], // max 1MB
            'remark' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'image' => 'setting image', // More user-friendly name for error messages
        ];
    }
}
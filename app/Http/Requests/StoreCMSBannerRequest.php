<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCMSBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set to true if authorization is handled by middleware (e.g., Sanctum)
        // or if this is a publicly accessible endpoint.
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
            'merchantId' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Active,Inactive'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'language' => ['required', 'string', 'max:255'],
            'index' => ['required', 'integer', 'min:0'], // Assuming index starts from 0 or 1
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'], // End date must be on or after start date
            'mobileImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Max 2MB
            'webImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Max 2MB
            'href' => ['nullable', 'url', 'max:2000'], // Validate as URL if present
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'merchantId' => 'merchant ID',
            'startDate' => 'start date',
            'endDate' => 'end date',
            'mobileImage' => 'mobile image',
            'webImage' => 'web image',
        ];
    }
}
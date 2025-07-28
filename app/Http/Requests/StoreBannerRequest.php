<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'merchantId' => ['required', 'string', 'max:255', 'in:MJB'],
            'contentType' => ['required', 'string', 'in:Home,Slot,Card,Fish,Instant Win,Bango,Login,Signup'], // NEW: Required and in allowed list
            'status' => ['required', 'in:Active,Inactive'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'language' => ['required', 'string', 'max:255', 'in:EN-BD'],
            'index' => ['required', 'integer', 'min:0'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'mobileImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'webImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            // 'href' validation rule is removed as it's no longer in the form
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'merchantId' => 'merchant ID',
            'contentType' => 'content type', // NEW: Custom attribute for content type
            'startDate' => 'start date',
            'endDate' => 'end date',
            'mobileImage' => 'mobile image',
            'webImage' => 'web image',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'endDate.after_or_equal' => 'The end date must be on or after the start date.',
            'mobileImage.required' => 'The mobile image file is required.',
            'webImage.required' => 'The web image file is required.',
            'contentType.in' => 'The selected content type is invalid.',
        ];
    }
}
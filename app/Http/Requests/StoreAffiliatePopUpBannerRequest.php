<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffiliatePopUpBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true for now; implement authorization later
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'merchantId' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
            'language' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'], // Adjust max if needed
            'link' => ['required', 'url', 'max:2048'], // 'url' validation
            'linkTarget' => ['required', 'string', 'in:current,new'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'], // End date must be on or after start date
            'mobileImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Max 2MB
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'merchantId' => 'merchant ID',
            'linkTarget' => 'link target',
            'startDate' => 'start date',
            'endDate' => 'end date',
            'mobileImage' => 'image',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            // Example custom message:
            // 'mobileImage.required' => 'Please upload an image for the banner.',
            // 'mobileImage.image' => 'The uploaded file must be an image.',
            // 'link.url' => 'The link must be a valid URL.',
            'endDate.after_or_equal' => 'The end date must be on or after the start date.',
        ];
    }
}
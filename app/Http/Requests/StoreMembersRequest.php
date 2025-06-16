<?php

// app/Http/Requests/StoreMemberRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'email' => 'required|email|unique:members,email',
            'currency' => 'required|in:BDT,NPR',
            'country_code' => 'required|string',
            'mobile_number' => 'required|string',
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|unique:members,username|max:255',
            'new_password' => 'required|string|min:8|confirmed',
            'force_password_change' => 'boolean',
            'bank' => 'nullable|string',
            'account_number' => 'nullable|string',
            'account_name' => 'nullable|string',
            'bank_branch' => 'nullable|string',
            'referral_code' => 'nullable|string',
            'affiliate_login' => 'nullable|string',
        ];
    }
}

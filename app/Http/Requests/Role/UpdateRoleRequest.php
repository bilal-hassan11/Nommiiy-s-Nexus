<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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

        return [
            'name' => 'required|string|max:255|unique:roles,name,NULL,id,system_user_id,' . $this->system_user_id,
            'permission_id' => 'required|array',
            'permission_id.*' => 'exists:permissions,id', // Validate each permission ID exists
        ];
    }
}

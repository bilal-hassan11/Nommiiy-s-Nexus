<?php

namespace App\Http\Requests\Supplier;

use App\Models\Supplier;
use App\Rules\UniqueScoped;
use App\Enums\SupplierStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
        $id = $this->route('supplier');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                new UniqueScoped(Supplier::class, 'name', $this->name,$id),
            ],
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'status' => 'nullable',
        ];
    }
}

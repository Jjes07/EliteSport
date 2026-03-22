<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use \Illuminate\Contracts\Validation\ValidationRule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'password' => 'nullable|string|min:8',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|string|max:10',
            'role' => 'nullable|string|in:admin,customer',
        ];
    }
}

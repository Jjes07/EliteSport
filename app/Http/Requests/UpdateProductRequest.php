<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\ValidationRule;

class UpdateProductRequest extends FormRequest
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
            "name" => "required|string",
            "description" => "required|string",
            "price" => "required|numeric|min:1",
            "stock" => "required|integer|min:0",
            "image" => "required|string",
            "category" => "required|string|in:Futbol,Voleibol"
        ];
    }
}

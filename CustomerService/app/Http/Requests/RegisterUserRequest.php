<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email|unique:users,email|max:255",
            "first_name" => "required|string|max:50",
            "last_name" => "required|string|max:50",
            "phone" => "required|string|max:15",
            "birth_date" => "required|date",
            "newsletter" => "boolean",
            "password" => "required|string|min:9|max:255",
            "repeat_password" => "required|same:password",
        ];
    }
}

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
            "email" => "required|email|unique:users,email|max:255",
            "first_name" => "required|alpha|max:50",
            "last_name" => "required|alpha|max:50",
            "password" => "required|string|min:9|max:255",
            "repeat_password" => "required|same:password",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required',
            'main_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'deleted_images' => 'nullable|array|max:9',
            'additional_images' => 'nullable|max:9',
            'deleted_images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'additional_images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}

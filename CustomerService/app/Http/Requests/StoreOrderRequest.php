<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'nip' => 'nullable|digits:10|regex:/^\d{10}$/',
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer',
            'status' => 'required|in:pending,preparation,sent,completed,cancelled',
            'amount' => 'required|numeric|min:0',
            'address_id' => 'required|integer|exists:addresses,id',
        ];
    }
}

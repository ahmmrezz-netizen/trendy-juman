<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'size' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'available_qty' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'size.required' => 'Product size is required.',
            'color.required' => 'Product color is required.',
            'available_qty.required' => 'Available quantity is required.',
            'available_qty.integer' => 'Available quantity must be a number.',
            'available_qty.min' => 'Available quantity cannot be negative.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
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
            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'Selected client does not exist.',
            'product_id.required' => 'Please select a product.',
            'product_id.exists' => 'Selected product does not exist.',
            'qty.required' => 'Quantity is required.',
            'qty.integer' => 'Quantity must be a number.',
            'qty.min' => 'Quantity must be at least 1.',
            'purchase_date.required' => 'Purchase date is required.',
            'purchase_date.date' => 'Please enter a valid date.',
        ];
    }
}

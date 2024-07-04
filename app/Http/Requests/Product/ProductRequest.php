<?php

namespace App\Http\Requests\Product;

use Illuminate\Validation\Rule;
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
        $id =$this->route('product');

        return [
            'name' => ["required", "string", "min:3", "max:255", Rule::unique('products','name')->ignore($id) ,
            ],
            'category_id' => 'required|numeric|exists:categories,id',
            'quantity' => 'required|numeric',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'status' => ['in:active,disable'],
            'featured' => 'nullable|integer|in:0,1',
            'image' => 'nullable',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'quantity' => 'required|numeric',

        ];
    }
}

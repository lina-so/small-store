<?php

namespace App\Http\Requests\Order;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Rules\Order\EnableQuantityRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'product_id' => [$this->isMethod('post')?'required':'sometimes','exists:products,id'],
            'ip_address' => 'nullable|ip',
            'quantity' => ['required','integer','min:1',new EnableQuantityRule($this->getProductQuantity())],
            'status' => [$this->isMethod('post')?'required':'sometimes','in:paid,waiting,delivered'],
        ];
    }

    public function getProductQuantity()
    {
        $productId = $this->product_id;
        $product = Product::find($productId);
        return $product ? $product->quantity : 0;
    }


}

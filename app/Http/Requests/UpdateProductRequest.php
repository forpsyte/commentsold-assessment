<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => ['required', 'max:128'],
            'description' => ['required', 'max:512'],
            'style' => ['required', 'max:32'],
            'brand' => ['required', 'max:32'],
            'url' => ['nullable', 'max:256'],
            'product_type' => ['required', 'max:255'],
            'shipping_price' => ['required', 'integer'],
            'note' => ['nullable', 'max:512']
        ];
    }
}

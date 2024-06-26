<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::check('update-product');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'description' => ['string', 'max:1000'],
            'proteins' => ['integer'],
            'fats' => ['integer'],
            'carbohydrates' => ['integer'],
            'composition' => ['string', 'max:1000'],
            'price' => ['integer'],
            'amount' => ['integer'],
            'image' => ['image', 'nullable']
        ];
    }
}

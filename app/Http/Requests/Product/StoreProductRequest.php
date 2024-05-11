<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::check('create-product');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['required', 'image'],
            'proteins' => ['required', 'integer'],
            'fats' => ['required', 'integer'],
            'carbohydrates' => ['required', 'integer'],
            'composition' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer']
        ];
    }
}

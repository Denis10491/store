<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['required'],
            'proteins' => ['required'],
            'fats' => ['required'],
            'carbohydrates' => ['required', 'string'],
            'composition' => ['required', 'string', 'max:1000'],
            'price' => ['required']
        ];
    }
}

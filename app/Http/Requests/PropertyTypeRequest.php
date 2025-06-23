<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyTypeRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:property_types,name,' . $this->route('property_type'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The property type name is required.',
            'name.string' => 'The property type name must be a string.',
            'name.max' => 'The property type name may not be greater than 255 characters.',
            'name.unique' => 'The property type name has already been taken.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypologyRequest extends FormRequest
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
            'tipo' => 'required|string|max:255',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tipo.required' => 'O campo tipo e obrigatorio.',
            'tipo.string' => 'O campo tipo deve ser uma string.',
            'tipo.max' => 'O campo tipo nao pode ter mais de 255 caracteres.',
        ];
    }
}

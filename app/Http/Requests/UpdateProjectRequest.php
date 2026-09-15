<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do projeto.',
            'name.string' => 'O nome do projeto é inválido.',
            'name.max' => 'O projeto pode ter no máximo 120 caracteres.',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkspaceRequest extends FormRequest
{

    public function authorize(): bool
    {
        /*
         * Por enquanto qualquer usuário autenticado
         * pode criar um Workspace.
         *
         * O middleware auth garante a autenticação.
         */
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
                'max:100'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do workspace.',
            'name.string' => 'O nome do workspace é inválido.',
            'name.max' => 'O nome do workspace pode ter no máximo 100 caracteres.',
        ];
    }
}

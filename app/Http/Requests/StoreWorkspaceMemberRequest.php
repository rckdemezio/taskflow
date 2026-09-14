<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreWorkspaceMemberRequest extends FormRequest
{
    /**
     * Por enquanto permitimos a requisição.
     *
     * Mais tarde isso será substituído por uma Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras dos dados recebidos.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'member',
                    'owner'
                ]),
            ],
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'email.required' => 'Informe o e-mail do usuário.',
            'email.email' => 'Informe um e-mail válido.',
            'email.exists' => 'Não encontramos um usuário cadastrado com o e-mail informado.',

            'role.required' => 'Selecione o papel do usuário.',
            'role.in' => 'O papel selecionado é inválido.',
        ];
    }
}

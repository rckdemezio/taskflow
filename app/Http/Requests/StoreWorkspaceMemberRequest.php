<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                ]),
            ],
        ];
    }
}

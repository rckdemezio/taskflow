<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UpdateWorkspaceMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Temporário
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
            'role' => [
                'required',
                Rule::in('admin', 'member', 'owner'),
            ],
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'role.required' => 'Selecione um papel para o membro.',
            'role.in' => 'O papel selecionado é inválido.',
        ];
    }
}

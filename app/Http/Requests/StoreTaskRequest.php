<?php

namespace App\Http\Requests;

use App\Models\Workspace;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
        /** @var Workspace $workspace */
        $workspace = $this->route('workspace');

        return [
            'title' => [
                'required',
                'string',
                'max:160',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in([
                    'todo',
                    'in_progress',
                    'done',
                ]),
            ],

            'priority' => [
                'required',
                Rule::in([
                    'low',
                    'medium',
                    'high',
                ]),
            ],

            'due_at' => [
                'nullable',
                'date',
            ],

            'assigned_to' => [
                'bail',
                'nullable',
                'integer',
                'exists:users,id',

                function (
                    string $attribute,
                    mixed $value,
                    Closure $fail
                ) use ($workspace): void {
                    if($value === null) {
                        return;
                    }

                    if ($workspace->owner_id === (int) $value) {
                        return;
                    }

                    $isMember = $workspace
                        ->users()
                        ->whereKey($value)
                        ->exists();
                    if(! $isMember) {
                        $fail(
                            'O responsável precisa participar deste workspace'
                        );
                    }
                },
            ],
        ];
    }
}

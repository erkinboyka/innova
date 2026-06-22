<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnologyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null
            && in_array($this->user()->role, ['scientist', 'agency'], true);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'trl' => ['nullable', 'integer', 'min:1', 'max:9'],
            'trl_answers' => ['nullable', 'array'],
            'trl_answers.*' => ['integer', 'min:1', 'max:9'],
            'organization_id' => ['nullable', 'exists:organizations,id'],
            'status' => ['required', 'string', 'in:draft,research,prototype,selling,licensing,investor_searching,ready'],
        ];
    }
}

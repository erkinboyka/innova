<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Technology;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTechnologyRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Technology|null $technology */
        $technology = $this->route('technology');

        return $this->user() !== null
            && $technology instanceof Technology
            && ($technology->owner_id === $this->user()->id || $this->user()->role === 'agency');
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

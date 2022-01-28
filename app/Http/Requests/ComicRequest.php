<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $requiredRule = $this->method() === 'POST' ? 'required' : 'sometimes';

        return [
            'title' => ['sometimes', 'string', 'max:200'],
            'issue_number' => [$requiredRule, 'integer', 'min:0', Rule::unique('comics')->where('series_id', $this->series_id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'format' => [$requiredRule, 'string', 'max:50'],
            'page_count' => ['nullable', 'integer', 'min:2', 'max:1000'],
        ];
    }
}

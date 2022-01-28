<?php

namespace App\Http\Requests;

use App\Models\Series;
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
        /** @var Series $series */
        $series = $this->route('series');
        $requiredRule = $this->method() === 'POST' ? 'required' : 'sometimes';

        return [
            'title' => ['sometimes', 'string', 'max:200'],
            'issue_number' => [$requiredRule, 'integer', 'min:0', Rule::unique('comics', 'issue_number')->where('series_id', $series->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'format' => [$requiredRule, 'string', 'max:50'],
            'page_count' => ['nullable', 'integer', 'min:2', 'max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'issue_number.unique' => 'This issue number is already in use for this series.',
        ];
    }
}

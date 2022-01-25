<?php

namespace App\Http\Requests;

use App\Rules\TwitterRule;
use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $requiredRule = $this->method() === 'POST' ? 'required' : 'sometimes';

        return [
            'name' => [$requiredRule, 'string', 'max:100', 'unique:publishers'],
            'founded_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'founded_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'founded_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'website_url' => ['nullable', 'string', 'max:255', 'url'],
            'twitter_url' => ['nullable', 'string', 'max:255', 'url', new TwitterRule()],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class SeriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $requiredRule = $this->method() === 'POST' ? 'required' : 'sometimes';

        return [
            'title' => [$requiredRule, 'string', 'max:150', 'unique:series'],
            'volume' => [$requiredRule, 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
            'start_year' => [$requiredRule, 'integer', 'min:1900', 'max:' . Carbon::now()->addYear()->year],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:' . Carbon::now()->addYear()->year],
            'rating' => ['nullable', 'string', 'max:30'],
            'type' => ['required', 'string', 'max:30'],
        ];
    }
}

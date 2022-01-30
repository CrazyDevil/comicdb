<?php

namespace App\Http\Requests;

use App\Models\Comic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Comic|null $comic */
        $comic = $this->route('comic');

        $requiredRule = $this->method() === 'POST' ? 'required' : 'sometimes';

        return [
            'identificator' => [$requiredRule, 'string', 'max:10', Rule::unique('covers', 'identificator')->where('comic_id', $comic?->id)],
            'name' => ['nullable', 'string', 'max:150'],
            'distributor_sku' => ['nullable', 'string', 'max:15'],
            'upc' => ['nullable', 'string', 'max:20'],
            'cover_path' => ['nullable', 'string', 'max:255'],
            'cover_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'release_date' => ['nullable', 'string', 'min:7', 'max:7'],
        ];
    }

    public function messages(): array
    {
        return [
            'identificator.unique' => 'This identificator is already in use for this comic.',
        ];
    }
}

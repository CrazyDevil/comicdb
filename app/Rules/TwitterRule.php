<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TwitterRule implements Rule
{
    public function passes($attribute, $value): bool|int
    {
        return preg_match('/http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/', $value);
    }

    public function message(): string
    {
        return 'The :attribute is not a valid twitter URL.';
    }
}

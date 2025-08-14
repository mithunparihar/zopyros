<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoDangerousTags implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(preg_match('/<\s*(php|script|html)[^>]*>/i', $value) || preg_match('/<\/\s*(php|script|html)[^>]*>/i', $value)) {
            $fail('The :attribute field must not contain dangerous tags such as PHP, script, or HTML.');
        } elseif (preg_match('/<\s*\/?\s*[^>]+>/i', $value)) {
            $fail('The :attribute field must not contain any HTML tags.');
        } elseif (strip_tags($value) !== $value) {
            $fail('The :attribute field must not contain HTML tags.');
        } elseif (is_numeric(strip_tags($value))) {
            $fail('The numeric value are not accepted.');
        }
    }
}

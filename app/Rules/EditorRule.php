<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EditorRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! empty($this->maxLength)) {
            $wordCount = str_word_count(strip_tags($value));
            if ($wordCount > $this->maxLength) {
                $fail('The :attribute must be at least ' . $this->maxLength . ' words.');
            }
        } elseif (preg_match("/^[^a-zA-Z0-9]+$/", strip_tags($value)) > 0) {
            $fail('You can`t add wrong format in this field.');
        } elseif (is_numeric(strip_tags($value))) {
            $fail('The numeric value are not accepted.');
        }elseif(preg_match('/<\s*(php|script)[^>]*>/i', $value) || preg_match('/<\/\s*(php|script)[^>]*>/i', $value)) {
            $fail('The :attribute field must not contain dangerous tags such as PHP or script.');
        }
    }
}

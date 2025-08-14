<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TextRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {
            if (preg_match("/\b(\w+)\s+\\1\b/i", strip_tags($value)) > 0) {
                $fail('You can`t add repeated word in this field.');
            } elseif (! empty($maxLength)) {
                $wordCount = str_word_count(strip_tags($value));
                if ($wordCount > $this->maxLength) {
                    $fail('The :attribute must be at least ' . $this->maxLength . ' words.');
                }
            } elseif (preg_match("/^[^a-zA-Z0-9]+$/", strip_tags($value)) > 0) {
                $fail('You can`t add wrong format in this field.');
            } elseif (! preg_match('/[a-zA-Z]/', strip_tags($value))) {
                $fail('Please add atleast one character.');
            }
        }

    }
}

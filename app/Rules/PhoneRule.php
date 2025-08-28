<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty(trim($value))) {
            $numbers = explode(',', $value);
            foreach ($numbers as $number) {
                $number = trim($number);
                if(!is_numeric($number)){
                    $fail("The :attribute '$number' is invalid.");
                }elseif(strlen($number)<8){
                    $fail("The :attribute '$number' must not be less than 8 digits.");
                }elseif(strlen($number)>12){
                    $fail("The :attribute '$number' must not be more than 12 digits.");
                }
            }
        }
    }
}

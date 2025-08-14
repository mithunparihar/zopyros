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
                // if (!preg_match('/^(\+?[0-9-]{1,4})?([0-9]{8,10})$/', $number)) {
                //     $fail("The phone number '$number' is invalid.");
                // }
                if(strlen($number)<8 && strlen($number)>12){
                    $fail("The :attribute '$number' is invalid.");
                }
            }
        }
    }
}

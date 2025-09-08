<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailRule implements ValidationRule
{
    public $uniqueTable, $uniqueColoum, $preId;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $explode = explode(',', $value);
        foreach ($explode as $value) {
            if (strtolower($value) != $value) {
                $fail('The :attribute field must be lowercase.');
            } else {
                $email = trim($value);
                $email = str_replace(" ", "", $email);
                if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                    $fail('Invalid email address.');
                }

                if (substr_count($email, '@') > 1) //more than one '@'?
                {
                    $fail('Invalid email address.');
                }

                if (preg_match("#[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/\s]#", $email)) {
                    $fail('Invalid email address.');
                } else if (preg_match("/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?)$/", $email)) {
                    true;
                } else {
                    $fail('Invalid email address.');
                }
            }
        }
    }
}

<?php

namespace App\Rules\birthDate;

use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDateOfBirth implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        $format = 'd/m/Y';

        // Create DateTime object from input
        $d = DateTime::createFromFormat($format, $value);

        // Check if the date is valid and matches the format
        if (!($d && $d->format($format) === $value)) {
            $fail('The :attribute must be a valid date.');
        }
    }
}

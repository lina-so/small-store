<?php

namespace App\Rules\Order;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnableQuantityRule implements ValidationRule
{
    public $maxQuantity;

    public function __construct($maxQuantity)
    {
        $this->maxQuantity = $maxQuantity;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value > $this->maxQuantity)
        {
            $fail("The $attribute must be less than $this->maxQuantity.");
        }
    }
}

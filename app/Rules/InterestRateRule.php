<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InterestRateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

   
    public function passes($attribute, $value)
    {
        if ($value > 0 && $value <= 100) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return 'The :attribute must not be less than 0 or greater than 100.';
    }
}

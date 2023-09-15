<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FormFormatRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Ensure $value is an array
        if (!is_array($value)) {
            $pattern = '/WP\/INTEC\/[A-Z]+\/[A-Z]+\/\d{2}-\d{2}$/';
            return preg_match($pattern, $value);
        }

        // Check each element in the array
        foreach ($value as $item) {
            $pattern = '/WP\/INTEC\/[A-Z]+\/[A-Z]+\/\d{2}-\d{2}$/';
            return preg_match($pattern, $item);
        }

    }


    public function message()
    {
        return 'The :attribute must follow the format: (Work Process)/(INTEC Code)/(Department Code)/(Unit Code)/(No. of Documents)-(No. of Forms)';
    }
}

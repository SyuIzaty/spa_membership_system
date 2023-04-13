<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FormCodeFormatRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Define a regular expression pattern to match the code format (Work Process)/(INTEC Code)/(Department Code)/(Unit Code)/(No. of Documents)-(No. of Forms)
        $pattern = '/^[A-Z]{2}\/INTEC\/[A-Z]{2}\/[A-Z]{2}\/\d{2}-\d{2}$/';

        // Check if the value matches the pattern
        return preg_match($pattern, $value);
    }

    public function message()
    {
        return 'The :attribute must follow the format (Work Process)/(INTEC Code)/(Department Code)/(Unit Code)/(No. of Documents)-(No. of Forms).';
    }
}

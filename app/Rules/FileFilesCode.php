<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileFilesCode implements Rule
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

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^INTEC\\.[A-Za-z]+\\.[A-Za-z]+\\.[0-9]+-[0-9]+\/[0-9]+\/[0-9]+$/', $value);
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must follow the format: [INTEC] . [DEP] . [UNIT] .
        [FUNCTION NO] - [ACTIVITY NO] / [SUB-ACTIVITY NO] / [FILE NO].';
    }
}

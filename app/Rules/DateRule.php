<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateRule implements Rule
{
    public function passes($attribute, $value)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $value);
        $minDate =  now()->addDays(4)->startOfDay();
        // $maxDate =  Carbon::now()->addYear(1)->endOfDay();
        return $date >= $minDate;
    }

    public function message()
    {
        return 'The departure date must be at least three days after today.';
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\SpaceBookingMain;
use App\SpaceBookingVenue;
use Carbon\Carbon;

class UpdateSpaceBookingRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $data;
    public function __construct(array $data)
    {
        $this->data = $data;
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
        $input = $this->data;
        $check = SpaceBookingVenue::where('venue_id', $input['venue'])
        ->where('application_status', 3)->where('id','!=',$input['id'])
        ->whereHas('spaceBookingMain', function ($query) use ($input) {
            $query->where(function ($query) use ($input) {
                $query->where('start_date', '<=', $input['end_date'])
                    ->where('end_date', '>=', $input['start_date'])
                    ->where(function ($query) use ($input) {
                        $query->where('start_time', '<=', $input['end_time'])
                            ->where('end_time', '>=', $input['start_time']);
                    });
            });
        })->get();

        if($check->count() >= 1){
            return false;
        }else{
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
        return 'Overlap with other application';
    }
}

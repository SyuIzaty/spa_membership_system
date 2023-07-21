<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\SpaceBookingMain;
use Carbon\Carbon;

class SpaceBookingRule implements Rule
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
        // dd($input);
        // $result = true;
        $result = [];
        $start = Carbon::parse($input['start_date']);
        $end = Carbon::parse($input['end_date']);
        foreach($input['venue'] as $key => $value){
            // $main = SpaceBookingMain::whereIn('start_date',$dates)
            // ->whereIn('end_date',$dates)
            // ->where('start_time','>=',date('H:i:s', strtotime($input['start_time'])))
            // ->where('end_time','>=',date('H:i:s', strtotime($input['end_time'])))
            // ->wherehas('spaceBookingVenues', function($query) use ($key){
            //     $query->where('venue_id',$key)->where('application_status',3);
            // })->get();
            $dates = [];
            for ($date = $start; $date->lte($end); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }
            $main = SpaceBookingMain::whereIn('start_date',$dates)
            ->whereIn('end_date',$dates)->where('start_time','>=',date('H:i:s', strtotime($input['start_time'])))
            ->where('end_time','>=',date('H:i:s', strtotime($input['end_time'])))
            ->get();
            dd($main);

            if($main->count() >= 1){
                $result[] = false;
            }

        }

        if(in_array('false',$result)){
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

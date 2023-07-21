<?php

namespace App\Http\Requests\Space;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'purpose' => 'required|max:200',
            'start_date' => [
                'required',
                'date',
                'before_or_equal:end_date',
                function ($attribute, $value, $fail) {
                    $today = now()->startOfDay();
                    $startDate = Carbon::parse($value)->startOfDay();
                    $difference = $today->diffInDays($startDate, false);
                    
                    if ($difference < 3) {
                        $fail('The :attribute must be at least three days.');
                    }
                },
                'after_or_equal:' . now()->format('Y-m-d'),
            ],
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|before_or_equal:end_time',
            'phone_number' => 'required|numeric',
            'office_no' => 'nullable|numeric',
        ];
    }
}

<?php

namespace App\Http\Requests\Space;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingManagementRequest extends FormRequest
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
            'no_user' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|before_or_equal:end_time',
            'phone_number' => 'required|numeric',
            'office_no' => 'nullable|numeric',
        ];
    }
}

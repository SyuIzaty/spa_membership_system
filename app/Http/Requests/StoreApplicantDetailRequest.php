<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreApplicantDetailRequest extends FormRequest
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
            'applicant_id' => 'required',
            'emergency_name' => 'required|min:1|max:100',
            'emergency_relationship' => 'required|min:1|max:100',
            'emergency_phone' => 'required|min:1|max:100',
            'emergency_address' => 'max:100',
            'applicant_address_1' => 'required|min:1|max:100',
            'applicant_address_2' => 'max:100',
            'applicant_poscode' => 'max:100',
            'applicant_city' => 'required|min:1|max:100',
            'applicant_state' => 'required|min:1|max:100',
            'applicant_country' => 'required|min:1|max:100',
            'guardian_one_name' => 'required|min:1|max:100',
            'guardian_one_relationship' => 'required|min:1|max:100',
            'guardian_one_mobile' => 'required|min:1|max:100',
            'guardian_one_address' => 'required|min:1|max:100',
            'guardian_two_name' => 'required|min:1|max:100',
            'guardian_two_relationship' => 'required|min:1|max:100',
            'guardian_two_mobile' => 'required|min:1|max:100',
            'guardian_two_address' => 'max:100',
        ];
    }
}

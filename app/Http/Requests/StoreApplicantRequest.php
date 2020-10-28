<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreApplicantRequest extends FormRequest
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
            'applicant_name' => 'required|min:1|max:100',
            'applicant_ic' => 'required|min:1|max:12',
            'applicant_phone' => 'required|numeric|min:1',
            'applicant_email' => 'required|min:1|max:100',
            'applicant_nationality' => 'required',
            'applicant_programme' => 'required',
        ];
    }
}

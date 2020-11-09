<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorRequest extends FormRequest
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
            'sponsor_code' => 'required|min:3|max:10',
            'sponsor_name' => 'required|min:3|max:50',
            'sponsor_number' => 'required|numeric',
            'sponsor_poscode' => 'numeric',
            'sponsor_email' => 'required|email',
            'sponsor_person' => 'required|min:5|max:20',
            'person_phone_1' => 'required|numeric',
            'person_email_1' => 'required|email',
            'sponsor_person_2' => 'sometimes|max:20',
            'person_phone_2' => 'sometimes|numeric',
            'person_email_2' => 'sometimes|required|email',
        ];
    }
}

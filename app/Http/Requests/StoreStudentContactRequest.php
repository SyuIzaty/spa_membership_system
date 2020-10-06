<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreStudentContactRequest extends FormRequest
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
            'students_phone' => 'required|min:1|max:100|regex:/(\+?0)[0-46-9]-*[0-9]{7,8}/',
            'students_email' => 'required',
            'students_address_1' => 'required|min:1|max:100',
            'students_address_2' => 'max:100',
            'students_poscode'  => 'required|max:100',
            'students_city' => 'required|min:1|max:100',
            'students_country' => 'required|min:1|max:100',
            'students_state' => 'required|min:1|max:100',
        ];
    }
}

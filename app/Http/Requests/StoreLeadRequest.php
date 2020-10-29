<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
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
            'leads_name'    => 'required|min:10|max:255',
            'leads_email'   => 'nullable|email|unique:leads,leads_email,' .$this->id,
            'leads_phone'   => 'required|min:9|max:11|regex:/(\+?0)[0-46-9]-*[0-9]{7,8}/|unique:leads,leads_phone,' .$this->id,
            'leads_ic'      => 'nullable|digits:12|regex:/^\d{6}\d{2}\d{4}$/|unique:leads,leads_ic,' .$this->id,
            'leads_source'  => '',
            'leads_event'  => 'max:255',
            'leads_prog1'   => '',
            'leads_prog2'   => '',
            'leads_prog3'   => '',
            'leads_status'  => '',
        ];
    }
}
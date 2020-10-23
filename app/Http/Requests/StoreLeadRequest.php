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
            'leads_name'    => 'max:255',
            'leads_email'   => 'nullable|unique:leads,leads_email,' .$this->id,   
            'leads_phone'   => 'nullable|unique:leads,leads_phone,' .$this->id,
            'leads_ic'      => 'nullable|unique:leads,leads_ic,' .$this->id,
            'leads_source'  => 'max:255',
            'leads_prog1'   => '',
            'leads_prog2'   => '',
            'leads_prog3'   => '',
            'leads_status'  => '',
        ];
    }
}
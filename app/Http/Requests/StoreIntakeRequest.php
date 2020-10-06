<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntakeRequest extends FormRequest
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
            'intake_code' => 'required',
            'intake_description' => 'required',
            'intake_app_open' => 'required',
            'intake_app_close' => 'required',
            'intake_check_open' => 'required',
            'intake_check_close' => 'required',
        ];
    }
}

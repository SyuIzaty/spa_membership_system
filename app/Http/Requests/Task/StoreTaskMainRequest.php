<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskMainRequest extends FormRequest
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
            'category' => 'required',
            'sub_category' => 'required|max:200',
            'type' => 'required',
            'department' => 'required',
            'progress' => 'required',
            'priority' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required',
        ];
    }
}

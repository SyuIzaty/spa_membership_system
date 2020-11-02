<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'course_id'         => 'required|max:255|unique:courses,id,' .$this->id,
            'course_code'       => 'required|max:255|unique:courses,course_code,' .$this->id,
            'course_name_bm'    => 'required|max:255',
            'course_name'       => 'required|max:255',
            'credit_hours'      => '', 
            'lecturer_hours'    => '',
            'lab_hours'         => '', 
            'tutorial_hours'    => '', 
            'exam_duration'     => '', 
            'final_exam'        => '', 
            'project_course'    => '',
            'course_status'     => 'required',
        ];
    }
}

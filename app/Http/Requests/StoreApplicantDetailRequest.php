<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\InternationalDocument;

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
        $input = $this->input();
        $rules = [
            'applicant_id' => 'required',
            'applicant_phone' => 'required|numeric|min:1',
            'applicant_gender' => 'required',
            'applicant_marital' => 'required',
            'applicant_race' => 'required',
            'applicant_religion' => 'required',
            'other_race' => 'max:20',
            'other_religion' => 'max:20',
            'applicant_address_1' => 'required|min:5|max:50',
            'applicant_address_2' => 'required|min:5|max:50',
            'applicant_poscode' => 'required|numeric',
            'applicant_city' => 'required|min:1|max:100',
            'applicant_state' => 'required|min:1|max:100',
            'applicant_country' => 'required|min:1|max:100',
            'guardian_one_name' => 'required|min:1|max:100',
            'guardian_one_relationship' => 'required|min:1|max:100',
            'guardian_one_mobile' => 'required|numeric|min:5',
            'guardian_one_address' => 'required|min:1|max:100',
            'guardian_two_name' => 'required|min:1|max:100',
            'guardian_two_relationship' => 'required|min:1|max:100',
            'guardian_two_mobile' => 'required|numeric|min:5',
            'guardian_two_address' => 'max:100',
            'highest_qualification' => 'required',
            'bachelor_cgpa' => 'numeric|min:1|max:4',
            'diploma_cgpa' => 'numeric|min:1|max:4',
            'matriculation_cgpa' => 'numeric|min:1|max:4',
            'foundation_cgpa' => 'numeric|min:1|max:4',
            'muet_cgpa' => 'integer|min:1|max:6',
            'declaration' => 'required',
            'passport_image' => 'mimes:jpeg,png,pdf',
            'passport' => 'mimes:jpeg,png,pdf',
            'academic_transcript' => 'mimes:jpeg,png,pdf',
            'cert_completion' => 'mimes:jpeg,png,pdf',
            'financial_statement' => 'mimes:jpeg,png,pdf',
            'acca_exemption' => 'mimes:jpeg,png,pdf'
        ];

        $except = ["declaration","acca_exemption","passport_image","passport","academic_transcript","cert_completion","financial_statement"];
        if( $input['applicant_nationality'] != "MYS")
        {
            foreach($except as $ekey => $evalue)
            {
                if($ekey > 1)
                {
                    $international = InternationalDocument::where('applicant_id',$input['id'])->with('applicant')->get();
                    if( !isset($international[$ekey - 2]) )
                    {
                        $rules[$evalue] .= "|required";
                    }
                }
            }
        }

        if( isset($input['chkEmergency']) )
        {
            $rules['emergency_name'] =  'required|min:1|max:100';
            $rules['emergency_relationship'] = 'required|min:1|max:100';
            $rules['emergency_phone'] = 'required|min:1|max:100';
            $rules['emergency_address'] = 'max:100';
        }

        $newrules = $rules;
        //if auto save escape the empty input validation
        if( isset($input['autoSave']) )
        {
            foreach($input as $key => $value)
            {
                if(!$value)
                {
                   $newrules[$key] = "";
                }
            }

            foreach($except as $evalue)
            {
                $newrules[$evalue] = "";
            }
        }

        return $newrules ? $newrules : $rules;
    }
}

<?php

namespace App\Exports;

use App\Applicant;
use App\ApplicantResult;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class ApplicantExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $intake = null , String $program = null, String $batch = null, String $status = null)
    {
        $this->intake = $intake;
        $this->program = $program;
        $this->batch = $batch;
        $this->status = $status;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cond = "1";

        if($this->intake && $this->intake != "All")
        {
            $cond .= " AND intake_id = ".$this->intake;
        }

        if($this->program && $this->program != "All")
        {
            $cond .= " AND offered_programme = '".$this->program."' ";
        }

        if($this->batch && $this->batch != "All")
        {
            $cond .= " AND batch_code = '".$this->batch."' ";
        }

        if($this->status && $this->status != "All")
        {
            $cond .= " AND applicant_status = '".$this->status."' ";
        }

        $list =  Applicant::whereRaw($cond)
        ->leftjoin('applicantresult','applicant.id','=',
        DB::Raw('applicantresult.applicant_id') )
        ->join('grades','applicantresult.grade_id','=','grades.id')
        ->join('genders','genders.gender_code','=','applicant.applicant_gender')
        ->join('intakes','intakes.id','=','applicant.intake_id')
        ->join('qualifications','qualifications.id','=','applicant.applicant_qualification')
        ->get();

        $collected1 = collect($list)->groupBy('applicant_id')->toarray();

        $collected = collect($list)->groupBy('applicant_id')->transform(function($item,$key){
            $data = [
                'Name' => "",
                'IC' => "",
                'Email' => "",
                'Phone' => "",
                'Gender' => "",
                'Intake' => "",
                'Student ID' => "",
                'Batch' => "",
                'Program' => "",
                'Major' => "",
                'Sponsor' => "",
                'Qualification' => "",
                '1103' => "",
                '1119' => "",
                '1449' => ""
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['Name'] =$ivalue->applicant_name;
                    $data['IC'] =$ivalue->applicant_ic;
                    $data['Email'] =$ivalue->applicant_email;
                    $data['Phone'] =$ivalue->applicant_phone;
                    $data['Gender'] =$ivalue->gender_name;
                    $data['Intake'] =$ivalue->intake_code;
                    $data['Student ID'] =$ivalue->student_id;
                    $data['Batch'] =$ivalue->batch_code;
                    $data['Program'] =$ivalue->offered_programme;
                    $data['Major'] =$ivalue->offered_major;
                    $data['Sponsor'] =$ivalue->sponsor_code;
                    $data['Qualification'] =$ivalue->qualification_code;
                }

                if( in_array($ivalue->subject,['1103','1119','1449']) )
                {
                    $data[$ivalue->subject] = $ivalue->grade_code;
                }
            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return ['APPLICANT NAME','APPLICANT IC','EMAIL','PHONE NUMBER','GENDER','INTAKE','STUDENT ID','BATCH',
                'OFFERED PROGRAMME','OFFERED MAJOR','SPONSOR CODE','HIGHEST QUALIFICATION','BM','ENG','MATH'];
    }

}

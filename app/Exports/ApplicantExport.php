<?php

namespace App\Exports;

use App\Applicant;
use App\ApplicantResult;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

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
        ->leftJoin('applicantresult','applicant.id','=','applicantresult.applicant_id')
        ->join('grades','applicantresult.grade_id','=','grades.id')
        ->join('genders','genders.gender_code','=','applicant.applicant_gender')
        ->join('intakes','intakes.id','=','applicant.intake_id')
        ->join('qualifications','qualifications.id','=','applicant.applicant_qualification')
        ->whereIn('applicantresult.subject',['1103','1119','1449'])
        ->get();

        $collected = collect($list)->groupBy('applicant_id')->transform(function($item,$key){
            $data = [];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    array_push($data,$ivalue->applicant_name);
                    array_push($data,$ivalue->applicant_ic);
                    array_push($data,$ivalue->applicant_email);
                    array_push($data,$ivalue->applicant_phone);
                    array_push($data,$ivalue->gender_name);
                    array_push($data,$ivalue->intake_code);
                    array_push($data,$ivalue->student_id);
                    array_push($data,$ivalue->batch_code);
                    array_push($data,$ivalue->offered_programme);
                    array_push($data,$ivalue->offered_major);
                    array_push($data,$ivalue->sponsor_code);
                    array_push($data,$ivalue->qualification_code);
                }
                array_push($data,$ivalue->grade_code);
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

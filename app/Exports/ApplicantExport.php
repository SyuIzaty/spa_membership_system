<?php

namespace App\Exports;

use App\Applicant;
use App\ApplicantResult;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicantExport implements FromCollection
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
                ->join('applicantresult','applicant.id','=','applicantresult.applicant_id')
                ->join('grades','applicantresult.grade_id','=','grades.id')
                ->whereIn('applicantresult.subject',['1103','2621','3729'])
                ->get();
        return $list;
    }
}

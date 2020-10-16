<?php

namespace App\Exports;

use App\Applicant;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicantExport implements FromCollection
{
    use Exportable;
    public function __construct(String $intake = null , String $programme = null, String $status = null)
    {
        $this->intake = $intake;
        $this->programme = $programme;
        $this->status = $status;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $applicant = Applicant::where('intake_id',$this->intake)->where('applicant_programme',$this->programme)->where('applicant_status',$this->status)->with(['applicantIntake','status'])->get();
        $changed = $applicant->map(function ($value, $key) {
            $value['intake_id'] = $value['applicantIntake']['intake_code'];
            $value['applicant_status'] = $value['status']['status_description'];
            return $value;
        });
        return $changed;
    }
}

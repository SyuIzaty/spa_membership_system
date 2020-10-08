<?php

namespace App\Exports;

use App\Applicant;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicantExport implements FromCollection
{
    use Exportable;
    public function __construct(String $intake = null , String $batch = null, String $programme = null, String $status = null)
    {
        $this->intake = $intake;
        $this->batch = $batch;
        $this->programme = $programme;
        $this->status = $status;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $applicant = Applicant::where('intake_id',$this->intake)->where('batch_code',$this->batch)->where('applicant_programme',$this->programme)->where('applicant_status',$this->status)->with(['applicantIntake'])->get();
        $changed = $applicant->map(function ($value, $key) {
            $value['intake_id'] = $value['applicantIntake']['intake_code'];
            return $value;
        });
        return $changed;
    }
}

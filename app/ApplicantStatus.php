<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    protected $table = 'applicant_status';

    protected $fillable = ['applicant_id','applicant_programme','applicant_status','student_id','applicant_major'];

    public function programme()
    {
        return $this->hasOne('App\Programme','id','applicant_programme');
    }

    public function applicant()
    {
        return $this->hasOne('App\Applicant','id','applicant_id');
    }

    public function major()
    {
        return $this->hasOne('App\Major','id','applicant_major');
    }
}

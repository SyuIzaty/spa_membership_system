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

    public function applicantresult()
    {
        return $this->hasMany('App\ApplicantResult', 'applicant_id', 'applicant_id');
    }

    public function statusResult()
    {
        return $this->hasOne('App\RequirementStatus','id','programme_status')->withDefault();
    }

    public function statusResultTwo()
    {
        return $this->hasOne('App\RequirementStatus','id','programme_status_2')->withDefault();
    }

    public function statusResultThree()
    {
        return $this->hasOne('App\RequirementStatus','id','programme_status_3')->withDefault();
    }
}

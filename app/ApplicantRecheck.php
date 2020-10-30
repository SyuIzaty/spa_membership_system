<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantRecheck extends Model
{
    protected $table = 'applicant_rechecks';

    protected $fillable = ['applicant_id', 'programme_code'];

    public function programme()
    {
        return $this->hasOne('App\Programme','programme_code','programme_code');
    }

    public function applicant()
    {
        return $this->hasOne('App\Applicant','id','applicant_id');
    }

    public function intakeDetails()
    {
        return $this->hasMany('App\IntakeDetail','intake_programme','programme_code');
    }
}

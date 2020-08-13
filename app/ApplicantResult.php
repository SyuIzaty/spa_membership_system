<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantResult extends Model
{

    protected $table = 'applicantresult';

    public function applicant()
    {
        return $this->hasMany('App\Applicant');
    }

    public function grading()
    {
        return $this->hasOne('App\Grading');
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject','subject_code','subject');
    }

    public function grades()
    {
        return $this->belongsTo('App\Grades','grade_id')->withDefault();
    }

    
}

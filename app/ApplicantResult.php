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

    
}

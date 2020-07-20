<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantResult extends Model
{

    protected $table = 'applicant_results';

    public function applicant()
    {
        return $this->hasMany('App\Applicant');
    }

    public function grading()
    {
        return $this->hasOne('App\Grading');
    }

    
}

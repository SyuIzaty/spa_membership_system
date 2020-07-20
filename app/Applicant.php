<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicant';

    public function applicantresult()
    {
        return $this->belongsTo('App\ApplicantResult');
    }

    public function programme()
    {
        return $this->belongsTo('App\Programme','id');
    }
}

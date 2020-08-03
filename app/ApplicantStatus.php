<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    protected $table = 'applicant_status';

    protected $fillable = ['applicant_id','applicant_programme','applicant_status'];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant','applicant_id','id');
    }

    public function programme()
    {
        return $this->belongsTo('App\Programme','applicant_programme','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicant';
    // Set mass-assignable fields
    protected $fillable = ['applicant_name', 'applicant_ic', 'applicant_email', 'applicant_phone', 'applicant_nationality', 'applicant_programme','programme_name'];

    public function applicantresult()
    {
        return $this->belongsTo('App\ApplicantResult');
    }

    /*public function programme()
    {
        return $this->belongsTo('App\Programme','id');
    }*/

    public function programme()
    {
        return $this->hasMany('App\Programme','id','applicant_programme');
    }

    public function applicantstatus()
    {
        return $this->hasMany('App\ApplicantStatus','applicant_id','id');
    }
}

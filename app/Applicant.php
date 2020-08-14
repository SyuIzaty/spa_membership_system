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
        return $this->hasMany('App\ApplicantResult', 'applicant_id', 'id');
    }

    /*public function programme()
    {
        return $this->belongsTo('App\Programme','id');
    }*/

    public function programme()
    {
        return $this->hasOne('App\Programme','id','applicant_programme');
    }

    public function programmeTwo()
    {
        return $this->hasOne('App\Programme','id','applicant_programme_2');
    }

    public function programmeThree()
    {
        return $this->hasOne('App\Programme','id','applicant_programme_3');
    }

    public function applicantstatus()
    {
        return $this->hasMany('App\ApplicantStatus','applicant_id','id');
    }

    public function storecontact()
    {
        return $this->hasManyThrough('App\ApplicantContact', 'applicant_id');
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

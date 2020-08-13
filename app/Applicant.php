<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicant';
    // Set mass-assignable fields
    protected $fillable = ['applicant_name', 'applicant_ic', 'applicant_email', 'applicant_phone', 'applicant_nationality', 'applicant_programme', 'applicant_programme_2', 'applicant_programme_3', 'applicant_gender', 'applicant_religion','programme_name'];

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

    public function prefprogramme()
    {
        return $this->hasMany('App\Programme','id','applicant_programme_2');
    }

    public function applicantstatus()
    {
        return $this->hasMany('App\ApplicantStatus','applicant_id','id');
    }

    public function storecontact()
    {
        return $this->hasManyThrough('App\ApplicantContact', 'applicant_id');
    }
}

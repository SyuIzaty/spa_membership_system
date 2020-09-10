<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicant';
    // Set mass-assignable fields
    protected $fillable = ['applicant_name', 'applicant_ic', 'applicant_email', 'applicant_phone', 'applicant_nationality', 'applicant_programme', 'applicant_programme_2', 'applicant_programme_3','applicant_major','applicant_major_2','applicant_major_3','programme_name', 'applicant_gender', 'applicant_religion','applicant_marital','applicant_race','applicant_dob'];
    protected $primaryKey = 'id';
    protected $foreignKey = 'applicant_id';
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

    public function majorOne()
    {
        return $this->hasOne('App\Major','id','applicant_major');
    }

    public function majorTwo()
    {
        return $this->hasOne('App\Major','id','applicant_major_2');
    }

    public function majorThree()
    {
        return $this->hasOne('App\Major','id','applicant_major_3');
    }

    public function applicantstatus()
    {
        return $this->hasOne('App\ApplicantStatus','applicant_id','id');
    }



    public function storecontact() {
    return $this->hasMany('App\ApplicantContact','applicant_id');
    }
    // public function storecontact(){

    //     return $this->belongsTo('App\ApplicantContact', 'applicant_id');

    // }

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

    public function applicantAcademic()
    {
        return $this->hasOne('App\ApplicantAcademic','applicant_id','id');
    }

    public function applicantIntake()
    {
        return $this->belongsTo('App\Intakes','intake_id','id');
    }

    public function applicantContactInfo()
    {
        return $this->hasOne('App\ApplicantContact','applicant_id','id');
    }

    public function applicantGuardian()
    {
        return $this->hasOne('App\ApplicantGuardian','applicant_id','id');
    }

    public function applicantEmergency()
    {
        return $this->hasOne('App\ApplicantEmergency','applicant_id','id');
    }

    public function country()
    {
        return $this->hasOne('App\Country','country_code', 'applicant_nationality');
    }
}

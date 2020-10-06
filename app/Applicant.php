<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Applicant extends Model implements HasMedia
{
    use LogsActivity, InteractsWithMedia;
    protected $table = 'applicant';
    // Set mass-assignable fields
    protected $fillable = ['applicant_name', 'applicant_ic', 'applicant_email', 'applicant_phone', 'applicant_nationality', 'applicant_programme', 'applicant_programme_2', 'applicant_programme_3','applicant_major','applicant_major_2','applicant_major_3','programme_name', 'applicant_gender', 'applicant_religion','applicant_marital','applicant_race','applicant_dob','intake_id'];
    protected $primaryKey = 'id';
    protected $foreignKey = 'applicant_id';

    protected static $logAttributes = true;

    public function applicantresult()
    {
        return $this->hasMany('App\ApplicantResult', 'applicant_id', 'id');
    }

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

    public function offeredMajor()
    {
        return $this->hasOne('App\Major','id','offered_major');
    }

    public function offeredProgramme()
    {
        return $this->hasOne('App\Programme','id','offered_programme');
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

    public function race()
    {
        return $this->hasOne('App\Race', 'race_code', 'applicant_race');
    }

    public function religion()
    {
        return $this->hasOne('App\Religion', 'religion_code', 'applicant_religion');
    }

    public function gender()
    {
        return $this->hasOne('App\Gender', 'gender_code', 'applicant_gender');
    }

    public function marital()
    {
        return $this->hasOne('App\Marital', 'marital_code', 'applicant_marital');
    }

    public function status()
    {
        return $this->hasOne('App\Status','status_code','applicant_status');
    }

    public function intakeDetail()
    {
        return $this->hasOne('App\IntakeDetail', 'intake_code', 'intake_id');
    }

    public function scopeApplicantId($query, $applicantt)
    {
        return $query->where('id',$applicantt);
    }

}

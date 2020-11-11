<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;

class Applicant extends Model
{
    use LogsActivity;
    protected $table = 'applicant';
    // Set mass-assignable fields
    protected $fillable = ['applicant_name', 'applicant_ic', 'applicant_email', 'applicant_phone', 'applicant_status',
                            'applicant_nationality', 'applicant_programme', 'applicant_programme_2', 'applicant_programme_3','applicant_major',
                            'applicant_major_2','applicant_major_3','programme_name', 'applicant_gender', 'applicant_religion',
                            'applicant_marital','applicant_race','applicant_dob','intake_id','sponsor_code','applicant_qualification',
                            'email_sent','intake_offer','other_race','other_religion','applicant_mode','applicant_mode_2','applicant_mode_3','declaration'];

    protected $primaryKey = 'id';
    protected $foreignKey = 'applicant_id';

    // Activity Log
    public static function firstRegistration($applicant) // First time registration
    {
        activity()->log('First Time Registration')->update(['subject_id'=>$applicant, 'subject_type'=>'App\Applicant']);
    }

    public static function completeApplication($applicant) // Complete Application
    {
        activity()->log('Application Complete')->update(['subject_id'=>$applicant, 'subject_type'=>'App\Applicant']);
    }

    public static function changeIntake($applicant) // Change Intake Session
    {
        activity()->log('Change Intake Session')->update(['subject_id'=>$applicant, 'subject_type'=>'App\Applicant']);
    }

    public static function requirementCheck($applicant) // Requirement Check
    {
        activity()->log('Requirement Check')->update(['subject_id'=>$applicant, 'subject_type'=>'App\Applicant']);
    }

    public static function recheckQualification($applicant) // Recheck Qualified Programme
    {
        activity()->log('Recheck Qualification')->update(['subject_id'=>$applicant, 'subject_type'=>'App\Applicant']);
    }

    public static function updateStatus($applicant, $programme, $major) // Offer Programme
    {
        activity()->log('Offer Programe')->update(['subject_id'=>$applicant, 'subject_type'=>'App\Applicant', 'properties'=>['programme'=>$programme]]);
    }


    // Relation
    public function applicantRechecks()
    {
        return $this->hasMany('App\ApplicantRecheck','applicant_id','id');
    }

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

    public function offeredMode()
    {
        return $this->hasOne('App\Mode', 'id', 'offered_mode');
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

    public function programmeStatus()
    {
        return $this->hasOne('App\Status','status_code','programme_status');
    }

    public function programmeStatusTwo()
    {
        return $this->hasOne('App\Status','status_code','programme_status_2');
    }

    public function programmeStatusThree()
    {
        return $this->hasOne('App\Status','status_code','programme_status_3');
    }

    public function statusResult()
    {
        return $this->hasOne('App\RequirementStatus','status','programme_status')->withDefault();
    }

    public function statusResultTwo()
    {
        return $this->hasOne('App\RequirementStatus','status','programme_status_2')->withDefault();
    }

    public function statusResultThree()
    {
        return $this->hasOne('App\RequirementStatus','status','programme_status_3')->withDefault();
    }

    public function applicantAcademic()
    {
        return $this->hasOne('App\ApplicantAcademic','applicant_id','id');
    }

    public function applicantIntake()
    {
        return $this->belongsTo('App\Intakes','intake_id','id');
    }

    public function applicantIntakeOffer()
    {
        return $this->belongsTo('App\Intakes','intake_offer','id');
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

    public function intake()
    {
        return $this->hasOne('App\Intakes','id','intake_id');
    }

    public function batch()
    {
        return $this->hasOne('App\Batch','batch_code','batch_code');
    }

    public function qualification()
    {
        return $this->hasOne('App\Qualification','id','applicant_qualification');
    }

    public function attachmentFile()
    {
        return $this->hasMany('App\AttachmentFile','batch_code','batch_code');
    }

    public function scopeApplicantId($query, $applicantt)
    {
        return $query->where('id',$applicantt);
    }
}

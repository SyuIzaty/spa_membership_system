<?php

namespace App;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Model;
class ApplicantAcademic extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = 'applicant_academic';
    // Set mass-assignable fields
    protected $fillable = ['applicant_id','applicant_study','applicant_year','applicant_major','applicant_cgpa','type','updated_at','created_at'];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant','applicant_id','id');
    }

    public function qualifications()
    {
        return $this->hasOne('App\Qualification','id','type');
    }
}

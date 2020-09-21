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
    protected $fillable = ['applicant_id','type','applicant_study','applicant_year','applicant_major'];
}

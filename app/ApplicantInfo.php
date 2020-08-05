<?php

namespace App;
use App\Applicant;
use Illuminate\Database\Eloquent\Model;

class ApplicantInfo extends Model
{
    protected $table = 'applicant';

    // Set mass-assignable fields
    protected $fillable = ['applicant_name', 'applicant_ic', 'applicant_email', 'applicant_phone', 'applicant_nationality', 'applicant_programme'];
    
}

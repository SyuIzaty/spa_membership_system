<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    protected $table = 'applicant_status';

    protected $fillable = ['applicant_id','applicant_programme','applicant_status'];
}

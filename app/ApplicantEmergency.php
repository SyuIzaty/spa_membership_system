<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantEmergency extends Model
{
    protected $table = 'applicant_emergency';

    protected $fillable = ['applicant_id','emergency_name','emergency_phone','emergency_address','emergency_relationship'];
}

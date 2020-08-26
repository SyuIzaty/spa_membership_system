<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantAcademic extends Model
{
    //
    protected $table = 'applicant_academic';
    // Set mass-assignable fields
    //JANGAN DITUKAR
    protected $fillable = ['applicant_id','type'];
}

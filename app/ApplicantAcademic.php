<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantAcademic extends Model
{
    //
    protected $table = 'applicant_academic';
    // Set mass-assignable fields
    protected $fillable = ['qualification_id','qualification_type'];
    protected $KeyType = 'string';
    protected $incrementing = false;
}

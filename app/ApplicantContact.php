<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantContact extends Model
{
    protected $table = 'applicant_contact_info';
    // Set mass-assignable fields
    protected $fillable = ['applicant_id','applicant_address_1', 'applicant_address_2', 'applicant_poscode', 'applicant_city', 'applicant_state', 'applicant_country', 'applicant_phone_office', 'applicant_phone_mobile', 'applicant_phone_home', 'applicant_email'];

}

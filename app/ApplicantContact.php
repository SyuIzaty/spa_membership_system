<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantContact extends Model
{
    protected $table = 'applicant_contact_info';

    protected $foreignKey = 'applicant_id';

    protected $fillable = ['applicant_id','applicant_address_1','applicant_address_2','applicant_poscode','applicant_city','applicant_state','applicant_country'];

    public function applicant()
    {
        return $this->hasOne('App\Applicant','id','applicant_id');
    }

    public function country()
    {
        return $this->hasOne('App\Country','country_code','applicant_country');
    }
}

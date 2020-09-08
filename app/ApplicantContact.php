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

    // public function store()
    // {
    //     return $this->belongsTo('App\Applicant','id');
    // }

    public function store() {
        return $this->belongsTo('App\Applicant', 'applicant_id', 'id');
    }

    public function applicantid()
    {
        return $this->hasOne('App\Applicant','id');
    }
}

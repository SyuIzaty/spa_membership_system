<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentContact extends Model
{
    protected $table = 'students_contact_info';
    protected $fillable = ['students_id','students_address_1', 'students_address_2', 'students_poscode', 'students_city', 'students_state', 'students_country', 'students_phone_office', 'students_phone_mobile', 'students_phone_home', 'students_email'];
    protected $foreignKey = 'students_id';

    public function student()
    {
        return $this->belongsTo('App\Student','students_id','id');
    }

    public function country()
    {
        return $this->hasOne('App\Country','country_code', 'students_country'); 
    }

    public function state()
    {
        return $this->hasOne('App\State','state_code', 'students_state'); 
    }

    public function store() 
    {
        return $this->belongsTo('App\Student', 'students_id', 'id');
    }

    public function studentid()
    {
        return $this->hasOne('App\Student','id');
    }
}

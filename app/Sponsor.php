<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use SoftDeletes;
    protected $table = 'sponsors';

    protected $fillable = ['sponsor_code', 'sponsor_name', 'sponsor_number', 'sponsor_email', 'sponsor_address_1', 'sponsor_address_2', 'sponsor_poscode', 'sponsor_city', 'sponsor_state', 'sponsor_person', 'sponsor_dept','person_phone_1','person_email_1','sponsor_person_2','person_phone_2','person_email_2'];
}

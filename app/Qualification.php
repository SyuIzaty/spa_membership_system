<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $table = 'qualifications';
    public function applicant()
    {
        return $this->hasMany('App\Applicant');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = 'programmes';

    public function applicant()
    {
        $this->belongsTo('App\Applicant','applicant_programme');
    }
}

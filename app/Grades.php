<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    protected $table = 'grades';
    public function applicantresult()
    {
        return $this->belongsTo('App\ApplicantResult','grade','grade_point');
    }
}

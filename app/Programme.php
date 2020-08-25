<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = 'programmes';
    protected $keyType = 'string';
    public $incrementing = false;

    public function applicant()
    {
        $this->belongsTo('App\Applicant','applicant_programme');
    }

}

class Programme2 extends Model
{
    protected $table = 'programmes';
}

class Programme3 extends Model
{
    protected $table = 'programmes';
}

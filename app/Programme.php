<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = 'programmes';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','programme_code','programme_name','programme_duration',
    ];

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

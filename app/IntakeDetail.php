<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntakeDetail extends Model
{
    use SoftDeletes;
    protected $table = 'intake_details';

    protected $fillable = [
        'intake_code', 'intake_date', 'intake_time', 'intake_venue', 'intake_programme', 'intake_programme_description', 'intake_type', 'batch_code'
    ];

    public function programme()
    {
        return $this->hasOne('App\Programme','id','intake_programme');
    }

    public function intakeType()
    {
        return $this->hasOne('App\IntakeType','id','intake_type');
    }

    public function intakes()
    {
        return $this->hasMany('App\Intakes','id','intake_code');
    }
}

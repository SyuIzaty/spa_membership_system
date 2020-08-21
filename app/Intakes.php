<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intakes extends Model
{
    use SoftDeletes;
    protected $table = 'intakes';

    protected $fillable = [
        'intake_code', 'intake_description', 'intake_app_open', 'intake_app_close', 'intake_check_open', 'intake_check_close', 'status'
    ];

    public function intakeDetails()
    {
        return $this->hasMany('App\IntakeDetail','intake_code','id');
    }

}

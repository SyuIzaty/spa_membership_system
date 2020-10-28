<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Intakes extends Model
{
    use SoftDeletes, LogsActivity;
    protected $table = 'intakes';

    protected $fillable = [
        'intake_code', 'intake_description', 'intake_app_open', 'intake_app_close', 'intake_check_open', 'intake_check_close', 'status'
    ];

    protected static $logFillable = true;

    public function intakeDetails()
    {
        return $this->hasMany('App\IntakeDetail','intake_code','id');
    }

    public function scopeActive($query)
    {
        return $query('status','1');
    }

    public function applicants()
    {
        return $this->hasMany('App\Applicant','intake_id','id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingHourTrail extends Model
{
    use SoftDeletes;
    protected $table = 'thr_hour_trail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'year', 'staff_id', 'status'
    ];

    public function hour_year()
    {
        return $this->hasOne('App\TrainingHourYear', 'year', 'year');
    }

    public function record_status()
    {
        return $this->hasOne('App\TrainingStatus', 'id', 'status')->where('status_type', 'TR');
    }

    public function staffs()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'staff_id');
    }
}

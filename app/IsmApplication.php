<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsmApplication extends Model
{
    use SoftDeletes;

    protected $fillable = ['applicant_id','applicant_email','applicant_phone','applicant_dept', 'applicant_verification', 'current_status'];

    public function status()
    {
        return $this->hasOne('App\IsmStatus', 'status_code', 'current_status');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'applicant_id');
    }

    public function department()
    {
        return $this->hasOne('App\Departments', 'department_code', 'applicant_dept');
    }

    public function applicationTracks()
    {
        return $this->hasMany('App\IsmApplicationTrack','application_id');
    }

    public function stationeries()
    {
        return $this->hasMany('App\IsmStationery','application_id');
    }

    public function countNewApplication()
    {
        return $this->where('current_status', 'NA')->count();
    }

    public function countRejected()
    {
        return $this->whereIn('current_status', ['RA', 'RV'])->count();
    }

    public function countPendingApproval()
    {
        return $this->where('current_status', 'PA')->count();
    }

    public function countReadyCollection()
    {
        return $this->where('current_status', 'RC')->count();
    }

    public function countAwaitingConfirmation()
    {
        return $this->where('current_status', 'AC')->count();
    }

    public function countComplete()
    {
        return $this->where('current_status', 'CP')->count();
    }
}

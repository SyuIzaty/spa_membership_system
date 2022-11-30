<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaan extends Model
{
    use SoftDeletes;

    protected $table = 'ekn_details';
    protected $fillable = [
        'intec_id', 'phone_no', 'depart_date', 'depart_time', 'return_date', 'return_time',
        'destination', 'waiting_area', 'purpose', 'total_passenger', 'driver',
        'vehicle', 'status', 'category', 'hod_hop_approval', 'operation_approval', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function waitingArea()
    {
        return $this->hasOne(Department::class, 'id', 'waiting_area');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'students_id', 'intec_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'intec_id');
    }

    public function programmes()
    {
        return $this->hasOne('App\Programmes', 'id', 'students_programme');
    }

    public function vehicleList()
    {
        return $this->hasOne(eKenderaanVehicles::class, 'id', 'vehicle');
    }

    public function driverList()
    {
        return $this->hasOne(eKenderaanDrivers::class, 'id', 'driver');
    }

    public function statusList()
    {
        return $this->hasOne(eKenderaanStatus::class, 'id', 'status');
    }

    public function feedback()
    {
        return $this->hasOne(eKenderaanFeedback::class, 'ekn_details_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(eKenderaanAttachments::class, 'ekn_details_id', 'id');
    }

    public function passengers()
    {
        return $this->hasMany(eKenderaanPassengers::class, 'ekn_details_id', 'id');
    }

    public function countOperationPending()
    {
        return $this->where('status', 2)->count();
    }

    public function countAdminVerified()
    {
        return $this->where('status', 3)->count();
    }

    public function countRejected()
    {
        return $this->where('status', 4)->count();
    }

    public function countFeedbackSubmitted()
    {
        return $this->where('status', 5)->count();
    }
}

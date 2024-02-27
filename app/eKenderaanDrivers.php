<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanDrivers extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_drivers';
    protected $fillable = [
        'name', 'staff_id', 'tel_no', 'status', 'color', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function driverDetails()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'staff_id');
    }

    public function assignedDriver()
    {
        return $this->hasOne(eKenderaanAssignDriver::class, 'driver_id', 'staff_id');
    }
}

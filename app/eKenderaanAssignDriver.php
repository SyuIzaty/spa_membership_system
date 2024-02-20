<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanAssignDriver extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_assign_drivers';
    protected $fillable = [
        'ekn_details_id', 'driver_id', 'rating', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function driverList()
    {
        return $this->hasOne(eKenderaanDrivers::class, 'id', 'driver_id');
    }

    public function driverName()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'driver_id');
    }

    public function details()
    {
        return $this->hasOne(eKenderaan::class, 'id', 'ekn_details_id');
    }
}

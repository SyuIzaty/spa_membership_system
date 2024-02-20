<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanVehicles extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_vehicles';
    protected $fillable = [
        'name', 'plate_no', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function assignedVehicle()
    {
        return $this->hasOne(eKenderaanAssignVehicle::class, 'vehicle_id', 'staff_id');
    }
}

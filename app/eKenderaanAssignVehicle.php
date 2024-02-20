<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanAssignVehicle extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_assign_vehicles';
    protected $fillable = [
        'ekn_details_id', 'vehicle_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function vehicleList()
    {
        return $this->hasOne(eKenderaanVehicles::class, 'id', 'vehicle_id');
    }

    public function details()
    {
        return $this->hasOne(eKenderaan::class, 'id', 'ekn_details_id');
    }
}

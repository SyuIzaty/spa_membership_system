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
}

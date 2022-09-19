<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanDrivers extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_drivers';
    protected $fillable = [
        'name', 'staff_id', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityBlock extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'status_id',
        'color'
    ];

    public function facilityRooms()
    {
        return $this->hasMany('App\FacilityRoom','block_id','id');
    }

    public function facilityStatus()
    {
        return $this->hasOne('App\FacilityStatus','id','status_id');
    }
}

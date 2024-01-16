<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityRoomType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','status_id'];

    public function facilityStatus()
    {
        return $this->hasOne('App\FacilityStatus','id','status_id');
    }

    public function facilityRooms()
    {
        return $this->hasMany('App\FacilityRoom','room_id','id');
    }
}

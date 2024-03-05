<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceRoomType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','status_id','enable_generate'];

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status_id');
    }

    public function spaceRooms()
    {
        return $this->hasMany('App\SpaceRoom','room_id','id');
    }

    public function scopeStatusId($query)
    {
        return $query->where('status_id',1);
    }
}

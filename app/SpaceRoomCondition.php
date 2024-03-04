<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceRoomCondition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_id',
        'condition_id',
    ];

    public function spaceRoom()
    {
        return $this->hasOne('App\SpaceRoom','id','room_id');
    }

    public function spaceCondition()
    {
        return $this->hasOne('App\SpaceCondition','id','condition_id');
    }

    public function scopeRoomId($query, $room_id)
    {
        return $query->where('room_id',$room_id);
    }
}

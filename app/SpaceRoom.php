<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'block_id',
        'room_id',
        'floor',
        'name',
        'description',
        'capacity',
        'status_id',
        'remark',
        'created_at',
        'updated_by'
    ];

    public function spaceBlock()
    {
        return $this->hasOne('App\SpaceBlock','id','block_id');
    }

    public function spaceRoomType()
    {
        return $this->hasOne('App\SpaceRoomType','id','room_id');
    }

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status_id');
    }

    public function spaceItems()
    {
        return $this->hasMany('App\SpaceItem','room_id','id');
    }

    public function spaceRoomConditions()
    {
        return $this->hasMany('App\SpaceRoomCondition','room_id','id');
    }

    public function scopeBlockId($query, $block_id)
    {
        return $query->where('block_id',$block_id);
    }

    public function scopeRoomId($query, $room_id)
    {
        return $query->where('room_id',$room_id);
    }

    public function scopeStatusId($query, $status_id)
    {
        return $query->where('status_id',$status_id);
    }

    public function scopeFloorId($query, $floor)
    {
        return $query->where('floor',$floor);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'block_id',
        'room_id',
        'name',
        'description',
        'capacity',
        'status_id',
        'enable_generate',
        'remark'
    ];

    public function facilityBlock()
    {
        return $this->hasOne('App\FacilityBlock','id','block_id');
    }

    public function facilityRoomType()
    {
        return $this->hasOne('App\FacilityRoomType','id','room_id');
    }

    public function facilityStatus()
    {
        return $this->hasOne('App\FacilityStatus','id','status_id');
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
}

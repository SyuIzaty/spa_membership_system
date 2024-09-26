<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['room_id','item_category','item_id','serial_no','name','description','available_booking','quantity','department_id','status','updated_by'];

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status');
    }

    public function spaceBookingItems()
    {
        return $this->hasMany('App\SpaceBookingItem','item_id','id');
    }

    public function departmentList()
    {
        return $this->hasOne('App\DepartmentList','id','department_id');
    }

    public function spaceRoom()
    {
        return $this->hasOne('App\SpaceRoom','id','room_id');
    }

    public function asset()
    {
        return $this->hasOne('App\Asset','id','item_id');
    }

    public function stock()
    {
        return $this->hasOne('App\Stock','id','item_id');
    }

    public function spaceCategory()
    {
        return $this->hasOne('App\SpaceCategory','id','item_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status','1');
    }

    public function scopeBookingActive($query)
    {
        return $query->where('available_booking','1');
    }

    public function scopeMain($query)
    {
        return $query->where('category','Main');
    }

    public function scopeDepartmentId($query, $department_id)
    {
        return $query->where('department_id',$department_id);
    }

    public function scopeRoomId($query, $room_id)
    {
        return $query->where('room_id',$room_id);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','description','quantity','department_id','status'];

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

    public function scopeActive($query)
    {
        return $query->where('status','1');
    }

    public function scopeMain($query)
    {
        return $query->where('category','Main');
    }

    public function scopeDepartmentId($query, $department_id)
    {
        return $query->where('department_id',$department_id);
    }
}

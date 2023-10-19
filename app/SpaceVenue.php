<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceVenue extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','description','maximum','open_student','department_id','status'];

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status');
    }

    public function openStudent()
    {
        return $this->hasOne('App\SpaceStatus','id','open_student');
    }

    public function spaceBookingVenues()
    {
        return $this->hasMany('App\SpaceBookingVenue','venue_id','id');
    }

    public function departmentList()
    {
        return $this->hasOne('App\DepartmentList','id','department_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status','1');
    }

    public function scopeStudent($query)
    {
        return $query->where('open_student','7');
    }

    public function scopeDepartmentId($query, $department_id)
    {
        return $query->where('department_id',$department_id);
    }
}

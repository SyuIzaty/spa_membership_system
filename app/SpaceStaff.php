<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceStaff extends Model
{
    use SoftDeletes;

    protected $table = 'space_staffs';
    protected $fillable = ['staff_id','department_id'];

    public function departmentList()
    {
        return $this->hasOne('App\DepartmentList','id','department_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','staff_id');
    }

    public function scopeStaffId($query, $staff_id)
    {
        return $query->where('staff_id',$staff_id);
    }

    public function scopeDepartmentId($query, $department_id)
    {
        return $query->where('department_id',$department_id);
    }

}

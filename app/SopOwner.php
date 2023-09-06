<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopOwner extends Model
{
    use SoftDeletes;
    protected $fillable = ['owner_id','department_id','created_by','updated_by','deleted_by'];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'owner_id');
    }

    public function department()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'department_id');
    }
}

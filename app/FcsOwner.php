<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsOwner extends Model
{
    use SoftDeletes;
    protected $fillable = ['staff_id','dept_id','created_by','updated_by','deleted_by'];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'staff_id');
    }

    public function department()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'dept_id');
    }
}

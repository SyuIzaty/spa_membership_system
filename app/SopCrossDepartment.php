<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopCrossDepartment extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_list_id','dept_id','cross_dept_id','active','created_by','updated_by','deleted_by'];

    public function department()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'dept_id');
    }

    public function crossDepartment()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'cross_dept_id');
    }
}

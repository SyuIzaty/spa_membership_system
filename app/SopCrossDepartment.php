<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopCrossDepartment extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_lists_id','cross_dept_id','created_by','updated_by','deleted_by'];

    public function crossDepartment()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'cross_dept_id');
    }
}

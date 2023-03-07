<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentStaff extends Model
{
    use SoftDeletes;

    protected $table = 'dms_staff';
    protected $primarykey = 'id';
    protected $fillable = [
       'staff_id', 'department_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function department()
    {
        return $this->hasOne('App\DepartmentList', 'id', 'department_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'staff_id');
    }
}

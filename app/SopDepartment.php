<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopDepartment extends Model
{
    use SoftDeletes;
    protected $fillable = ['department_name','abbreviation','active','created_by','updated_by','deleted_by'];

    public function owners()
    {
        return $this->hasMany(FcsOwner::class, 'dept_id', 'id');
    }

}

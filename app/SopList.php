<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopList extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop','department_id','active','created_by','updated_by','deleted_by'];

    public function department()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'department_id');
    }

    public function getCD()
    {
        return $this->hasMany(SopCrossDepartment::class, 'sop_list_id', 'id');
    }


}

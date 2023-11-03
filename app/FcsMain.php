<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsMain extends Model
{
    use SoftDeletes;
    protected $fillable = ['dept_id','code','file','remark','created_by','updated_by','deleted_by'];

    public function department()
    {
        return $this->hasOne(SopDepartment::class, 'id', 'dept_id');
    }
}

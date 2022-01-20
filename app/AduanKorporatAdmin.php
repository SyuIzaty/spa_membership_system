<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanKorporatAdmin extends Model
{
    use SoftDeletes;

    protected $table = 'eak_admin';
    protected $primaryKey = 'id';
    protected $fillable = [
        'admin_id', 'department_id','created_by','updated_by','deleted_by'
    ];

    public function department()
    {
        return $this->hasOne('App\DepartmentList', 'id', 'department_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id','admin_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','admin_id');
    }
}

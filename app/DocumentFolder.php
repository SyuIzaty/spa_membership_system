<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFolder extends Model
{
    use SoftDeletes;

    protected $table = 'dms_folder';
    protected $primarykey = 'id';
    protected $fillable = [
        'department_id', 'title', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function department()
    {
        return $this->hasOne('App\DepartmentList', 'id', 'department_id');
    }

    public function admin()
    {
        return $this->hasOne('App\DocumentAdmin', 'department_id', 'department_id');
    }
}

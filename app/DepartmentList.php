<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentList extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'active'
    ];

    public function document()
    {
        return $this->hasMany('App\DocumentManagement', 'department_id', 'id');
    }
}

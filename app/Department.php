<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_department';
    protected $primaryKey = 'id';
    protected $fillable = [
        'department_name'
    ];
}

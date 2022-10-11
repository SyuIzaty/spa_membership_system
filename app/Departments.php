<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'departments';
    protected $fillable = ['hod', 'department_code','department_name'];
}

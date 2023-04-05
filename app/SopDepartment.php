<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopDepartment extends Model
{
    use SoftDeletes;
    protected $fillable = ['department','abbreviation','active','created_by','updated_by','deleted_by'];
}

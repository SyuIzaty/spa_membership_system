<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'staffs';
    protected $fillable = ['staff_id', 'staff_ic','staff_name','staff_email','staff_phone','staff_dept','staff_position','staff_training_hr'];
}

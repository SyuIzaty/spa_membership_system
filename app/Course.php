<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'oracle';
    protected $table = 'COURSE_MAIN';
    protected $primaryKey = 'CM_COURSE_CODE';
    public $incrementing = false;
}

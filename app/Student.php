<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'oracle';
    protected $table = 'STUDENT_MAIN';
    protected $primaryKey = 'SM_STUDENT_ID';
    public $incrementing = false;
}

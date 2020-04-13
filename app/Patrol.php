<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patrol extends Model
{
    public $connection = 'oracle';
    public $table = 'STUDENT_MAIN';
    public $primaryKey = 'SM_STUDENTID';
    public $incrementing = false;
}

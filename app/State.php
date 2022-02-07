<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'states';
    protected $primaryKey = 'state_code';

}

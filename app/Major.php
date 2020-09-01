<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'major';

    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'major';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';
}

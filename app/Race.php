<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $primaryKey = 'race_code';

    public $incrementing = false;
    protected $keyType = 'string';
}

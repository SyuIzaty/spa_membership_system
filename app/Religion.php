<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $primaryKey = 'religion_code';

    public $incrementing = false;
    protected $keyType = 'string';
}

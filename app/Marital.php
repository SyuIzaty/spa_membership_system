<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marital extends Model
{
    protected $primaryKey = 'marital_code';

    public $incrementing = false;
    protected $keyType = 'string';
}

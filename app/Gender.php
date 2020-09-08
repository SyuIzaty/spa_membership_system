<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $primaryKey = 'gender_code';

    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsmStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['status_code','status_name'];
}

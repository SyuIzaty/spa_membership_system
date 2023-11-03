<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['log','created_by','updated_by','deleted_by'];

}

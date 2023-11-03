<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsFunctionCode extends Model
{
    use SoftDeletes;
    protected $fillable = ['code','description','created_by','updated_by','deleted_by'];

}

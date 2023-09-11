<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopComment extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_lists_id','comment','created_by','updated_by','deleted_by'];
}

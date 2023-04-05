<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_details_id','user_id','activity','created_by','updated_by','deleted_by'];
}

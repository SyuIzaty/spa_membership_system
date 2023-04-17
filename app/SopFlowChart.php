<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopFlowChart extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_lists_id','upload','web_path','created_by','updated_by','deleted_by'];
}

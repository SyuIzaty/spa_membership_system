<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopDetail extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_lists_id','sop_dept_id','sop_code','prepared_by'
                            ,'reviewed_by','approved_by','purpose','scope','reference'
                            ,'definition','procedure','created_by','updated_by','deleted_by'
                          ];
}

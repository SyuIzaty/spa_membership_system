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

    public function prepare()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'prepared_by');
    }

    public function review()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'reviewed_by');
    }

    public function approve()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'approved_by');
    }
}

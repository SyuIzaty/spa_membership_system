<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['code_id','log','created_by','updated_by','deleted_by'];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'created_by');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsMainSub extends Model
{
    use SoftDeletes;
    protected $fillable = ['code_id','sub_code','file','remark','created_by','updated_by','deleted_by'];

    public function mainCode()
    {
        return $this->hasOne(FcsMain::class, 'id', 'code_id');
    }
}

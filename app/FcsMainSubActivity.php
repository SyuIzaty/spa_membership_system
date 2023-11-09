<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsMainSubActivity extends Model
{
    use SoftDeletes;
    protected $fillable = ['code_sub_id','code','file','remark','created_by','updated_by','deleted_by'];

    public function subCode()
    {
        return $this->hasOne(FcsMainSub::class, 'id', 'code_sub_id');
    }
}

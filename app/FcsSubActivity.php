<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcsSubActivity extends Model
{
    use SoftDeletes;
    protected $fillable = ['code_id','code','file','remark','sub_activity','created_by','updated_by','deleted_by'];

    public function mainCode()
    {
        return $this->hasOne(FcsActivity::class, 'id', 'code_id');
    }
}

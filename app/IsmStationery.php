<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsmStationery extends Model
{
    use SoftDeletes;

    protected $fillable = ['application_id','stock_id','request_quantity','request_remark','approve_quantity','approve_remark'];

    public function stock()
    {
        return $this->hasOne('App\Stock', 'id', 'stock_id');
    }
}

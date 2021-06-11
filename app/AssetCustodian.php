<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCustodian extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_custodian';
    protected $primaryKey = 'id';
    protected $fillable = [
        'custodian_id', 'department_id'
    ];

    public function department()
    {
        return $this->hasOne('App\AssetDepartment', 'id', 'department_id');
    }

    public function custodian()
    {
        return $this->hasOne('App\User', 'id', 'custodian_id');
    }
}

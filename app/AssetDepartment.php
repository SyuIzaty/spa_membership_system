<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDepartment extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'department_id', 'department_name'
    ];

    public function custodians()
    {
        return $this->hasMany('App\AssetCustodian', 'department_id');
    }

    public function department()
    {
        return $this->hasOne('App\Departments', 'id', 'department_id');
    }
}

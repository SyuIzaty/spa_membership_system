<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDepartment extends Model
{
    use SoftDeletes;
    protected $table = 'inv_department';
    protected $primaryKey = 'id';
    protected $fillable = [
        'department_name'
    ];

    public function custodians()
    {
        return $this->hasMany('App\AssetCustodian', 'department_id');
    }
}

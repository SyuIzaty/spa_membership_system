<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetType extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'department_id', 'asset_type'
    ];

    public function department()
    {
        return $this->hasOne('App\AssetDepartment', 'id', 'department_id');
    }
}

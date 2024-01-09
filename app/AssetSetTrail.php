<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetSetTrail extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_set_trails';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_set_id', 'asset_type', 'serial_no', 'model', 'brand', 'updated_by'
    ];

    public function type()
    {
        return $this->hasOne('App\AssetType', 'id', 'asset_type');
    }

    public function set()
    {
        return $this->hasOne('App\AssetSet', 'id', 'asset_set_id');
    }
}

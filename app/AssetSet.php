<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetSet extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_sets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id', 'asset_type', 'serial_no', 'model', 'brand'
    ];

    public function type()
    {
        return $this->hasOne('App\AssetType', 'id', 'asset_type');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_code', 'finance_code', 'asset_name', 'asset_type', 'serial_no', 'model', 'brand', 'total_price', 'lo_no', 'io_no', 'do_no', 'purchase_date', 'vendor_name', 
        'custodian_id', 'created_by', 'remark', 'status', 'availability', 'storage_location', 'set_package'
    ];

    public function type()
    {
        return $this->hasOne('App\AssetType', 'id', 'asset_type');
    }

    public function custodians()
    {
        return $this->hasOne('App\User', 'id', 'custodian_id');
    }

    public function assetCustodian()
    {
        return $this->hasMany('App\Custodian','asset_id');  
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function availabilities()
    {
        return $this->hasOne('App\AssetAvailability', 'id', 'availability');
    }

}

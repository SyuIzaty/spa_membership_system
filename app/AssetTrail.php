<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetTrail extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_trails';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_code', 'asset_code_type', 'finance_code', 'asset_name', 'asset_type', 'serial_no', 'model', 'brand', 'total_price', 'lo_no', 'io_no', 'do_no', 'purchase_date', 'acquisition_type', 'asset_class',
        'custodian_id', 'created_by', 'remark', 'status', 'inactive_reason', 'inactive_remark', 'inactive_date', 'availability', 'storage_location', 'set_package', 'updated_by', 'asset_id', 'vendor_name'
    ];

    public function codeType()
    {
        return $this->hasOne('App\AssetCodeType', 'id', 'asset_code_type');
    }

    public function acquisitionType()
    {
        return $this->hasOne('App\AssetAcquisition', 'id', 'acquisition_type');
    }

    public function assetStatus()
    {
        return $this->hasOne('App\AssetStatus', 'id', 'inactive_reason');
    }

    public function type()
    {
        return $this->hasOne('App\AssetType', 'id', 'asset_type');
    }

    public function assetClass()
    {
        return $this->hasOne('App\AssetClass', 'class_code', 'asset_class');
    }

    public function custodian()
    {
        return $this->hasOne('App\User', 'id', 'custodian_id');
    }

    public function assetCustodians()
    {
        return $this->hasMany('App\Custodian','asset_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function staffs()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    public function assetAvailability()
    {
        return $this->hasOne('App\AssetAvailability', 'id', 'availability');
    }
}

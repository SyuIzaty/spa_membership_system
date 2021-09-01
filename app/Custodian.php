<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Custodian extends Model
{
    use SoftDeletes;
    protected $table = 'inv_custodian';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id', 'custodian_id', 'reason_remark', 'assigned_by', 'verification', 'status', 'verification_date'
    ];

    public function assets()
    {
        return $this->hasOne('App\Asset', 'id', 'asset_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'custodian_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'assigned_by');
    }

    public function custodian()
    {
        return $this->hasOne('App\User', 'id', 'custodian_id');
    }

    public function custodianStatus()
    {
        return $this->hasOne('App\CustodianStatus', 'id', 'status');
    }
}

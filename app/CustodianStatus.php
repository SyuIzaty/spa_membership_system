<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustodianStatus extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_custodian_statuses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_name'
    ];
}

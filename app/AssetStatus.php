<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetStatus extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_name'
    ];
}

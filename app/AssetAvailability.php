<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetAvailability extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_availability';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
}

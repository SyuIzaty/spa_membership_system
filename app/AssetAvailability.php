<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetAvailability extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_availabilities';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
}

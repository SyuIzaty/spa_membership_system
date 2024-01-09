<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetAcquisition extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_acquisitions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'acquisition_type'
    ];
}

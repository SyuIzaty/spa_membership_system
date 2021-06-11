<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetImage extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_image';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id', 'upload_image', 'web_path'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetImage extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id', 'img_name','img_size','img_path'
    ];
}

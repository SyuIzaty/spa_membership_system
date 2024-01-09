<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetClass extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_classes';
    protected $fillable = ['class_code', 'class_name'];
    protected $primaryKey = 'class_code';

    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssetCodeType extends Model
{
    use SoftDeletes;
    protected $table = 'inv_asset_code_types';
    protected $fillable = ['id', 'code_name'];
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';
}

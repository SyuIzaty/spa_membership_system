<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssetCodeType extends Model
{
    use SoftDeletes;
    protected $table = 'inv_code_type';
    protected $fillable = ['id', 'code_name'];
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';
}

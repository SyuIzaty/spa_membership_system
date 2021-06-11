<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockImage extends Model
{
    use SoftDeletes;
    protected $table = 'inv_stock_image';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_id', 'upload_image', 'web_path'
    ];
}

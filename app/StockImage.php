<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockImage extends Model
{
    use SoftDeletes;
    protected $table = 'inv_stock_images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_id', 'img_name','img_size','img_path'
    ];
}

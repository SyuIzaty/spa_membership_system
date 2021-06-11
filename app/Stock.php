<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $table = 'inv_stock';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_code', 'stock_name', 'model', 'brand', 'status', 'created_by'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function transaction()
    {
        return $this->hasMany('App\StockTransaction','stock_id');  
    }

    public function invStatus()
    {
        return $this->hasOne('App\InventoryStatus', 'id', 'status');
    }
}

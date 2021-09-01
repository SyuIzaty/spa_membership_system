<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransaction extends Model
{
    use SoftDeletes;
    protected $table = 'inv_stock_transaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_id', 'stock_in', 'lo_no', 'io_no', 'unit_price', 'purchase_date', 'trans_date', 'remark', 'stock_out', 'reason', 'supply_type', 'ext_supply_to', 'supply_to', 'status', 'created_by'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function stocks()
    {
        return $this->belongsTo('App\Stock', 'id', 'stock_id');
    }

    public function users()
    {
        return $this->hasOne('App\User', 'id', 'supply_to');
    }
}

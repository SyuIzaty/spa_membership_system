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
        'stock_id', 'trans_date', 'lo_no', 'io_no', 'trans_in', 'trans_out', 'current_balance', 'unit_price', 'created_by', 'remark', 'status'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}

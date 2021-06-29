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
        'stock_code', 'stock_name', 'model', 'brand', 'status', 'created_by', 'department_id'
    ];

    public function type()
    {
        return $this->hasOne('App\AssetType', 'department_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function transaction()
    {
        return $this->hasMany('App\StockTransaction','stock_id')->orderBy('trans_date', 'asc');  
    }

    public function departments()
    {
        return $this->hasOne('App\AssetDepartment', 'id', 'department_id');
    }
}

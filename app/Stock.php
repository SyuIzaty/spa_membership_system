<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $table = 'inv_stocks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_code', 'stock_name', 'model', 'brand', 'status', 'created_by', 'current_owner', 'updated_by', 'department_id',
        'applicable_for_stationary', 'applicable_for_aduan', 'deleted_by'
    ];

    public function type()
    {
        return $this->hasOne('App\AssetType', 'department_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'current_owner');
    }

    public function transaction()
    {
        return $this->hasMany('App\StockTransaction','stock_id')->orderBy('trans_date', 'asc');
    }

    public function departments()
    {
        return $this->hasOne('App\Departments', 'department_code', 'department_id');
    }
}

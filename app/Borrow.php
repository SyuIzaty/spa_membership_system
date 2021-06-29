<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
    use SoftDeletes;
    protected $table = 'inv_borrower';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id', 'borrower_id', 'borrow_date', 'return_date', 'reason', 'created_by', 'remark', 'status', 'verified_by', 'actual_return_date'
    ];

    public function asset()
    {
        return $this->hasOne('App\Asset', 'id', 'asset_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function users()
    {
        return $this->hasOne('App\User', 'id', 'verified_by');
    }

    public function borrower()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'borrower_id');
    }

    public function borrow_status()
    {
        return $this->hasOne('App\BorrowStatus', 'id', 'status');
    }
}

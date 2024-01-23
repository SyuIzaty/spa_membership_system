<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use SoftDeletes;
    protected $table = 'inv_rentals';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id', 'staff_id', 'checkout_date', 'return_date', 'reason', 'checkout_by', 'return_to', 'status', 'remark'
    ];

    public function asset()
    {
        return $this->hasOne('App\Asset', 'id', 'asset_id');
    }

    public function checkoutBy()
    {
        return $this->hasOne('App\User', 'id', 'checkout_by');
    }

    public function returnTo()
    {
        return $this->hasOne('App\User', 'id', 'return_to');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'staff_id');
    }

    public function rental_status()
    {
        return $this->hasOne('App\RentalStatus', 'id', 'status');
    }
}

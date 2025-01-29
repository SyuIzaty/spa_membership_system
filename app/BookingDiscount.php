<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDiscount extends Model
{
    public $timestamps = false;

    protected $fillable = ['booking_id','discount_id'];

    public function discount()
    {
        return $this->hasOne('App\Discount', 'id', 'discount_id');
    }
}

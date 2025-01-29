<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id','booking_date','booking_time', 'booking_status', 'booking_payment', 'booking_payment_status','booking_duration','staff_id'];

    public function bookingStatus()
    {
        return $this->hasOne('App\BookingStatus', 'id', 'booking_status');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id', 'customer_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'user_id', 'staff_id');
    }

    public function bookingServices()
    {
        return $this->hasMany('App\BookingService', 'booking_id', 'id');
    }

    public function bookingDiscounts()
    {
        return $this->hasMany('App\BookingDiscount', 'booking_id', 'id');
    }
}

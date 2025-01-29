<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    public $timestamps = false;

    protected $fillable = ['booking_id','service_id'];

    public function service()
    {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }
}

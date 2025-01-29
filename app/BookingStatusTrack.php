<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingStatusTrack extends Model
{
    use SoftDeletes;

    protected $fillable = ['booking_id','booking_status_id','created_by'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['status_name','status_description','color'];
}

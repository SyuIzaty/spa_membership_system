<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsmConfirmationReminder extends Model
{
    use SoftDeletes;

    protected $fillable = ['application_track_id','created_by'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsmApplicationTrack extends Model
{
    use SoftDeletes;

    protected $fillable = ['application_id','status_id', 'remark', 'created_by'];

    public function status()
    {
        return $this->hasOne('App\IsmStatus', 'status_code', 'status_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'created_by');
    }

    public function confirmationReminders()
    {
        return $this->hasMany('App\IsmConfirmationReminder','application_track_id');
    }
}

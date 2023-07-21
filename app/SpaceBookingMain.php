<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceBookingMain extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['staff_id','user_phone','user_office','purpose','start_date','end_date','start_time','end_time'];

    public function spaceBookingVenues()
    {
        return $this->hasMany('App\SpaceBookingVenue','space_main_id','id');
    }

    public function spaceBookingItems()
    {
        return $this->hasMany('App\SpaceBookingItem','space_main_id','id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','staff_id');
    }

    public function verify()
    {
        return $this->hasOne('App\Staff','staff_id','verify_by');
    }

    public function scopeApplication($query)
    {
        return $query->where('category','Application');
    }
}

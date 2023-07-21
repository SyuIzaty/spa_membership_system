<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceBookingVenue extends Model
{
    use SoftDeletes;

    protected $fillable = ['space_main_id','venue_id','application_status','verify_by'];

    public function spaceBookingMain()
    {
        return $this->hasOne('App\SpaceBookingMain','id','space_main_id');
    }

    public function spaceBookingItems()
    {
        return $this->hasMany('App\SpaceBookingItem','space_main_id','space_main_id');
    }

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','application_status');
    }

    public function spaceVenue()
    {
        return $this->hasOne('App\SpaceVenue','id','venue_id');
    }

    public function scopeMainId($query, $space_main_id)
    {
        return $query->where('space_main_id',$space_main_id);
    }
}

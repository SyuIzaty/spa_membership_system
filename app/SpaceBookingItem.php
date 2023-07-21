<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceBookingItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['space_main_id','item_id','unit'];

    public function spaceBookingMain()
    {
        return $this->hasOne('App\SpaceBookingMain','id','space_main_id');
    }

    public function spaceBookingVenues()
    {
        return $this->hasMany('App\SpaceBookingVenue','space_main_id','space_main_id');
    }

    public function spaceItem()
    {
        return $this->hasOne('App\SpaceItem','id','item_id');
    }

    public function scopeMainId($query, $space_main_id)
    {
        return $query->where('space_main_id',$space_main_id);
    }
}

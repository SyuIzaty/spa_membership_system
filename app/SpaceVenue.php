<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceVenue extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','description','maximum','color','status'];

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status');
    }

    public function spaceBookingVenues()
    {
        return $this->hasMany('App\SpaceBookingVenue','venue_id','id');
    }

    public function scopeActive($query)
    {
        return $query->where('status','1');
    }

    public function scopeMain($query)
    {
        return $query->where('category','Main');
    }
}

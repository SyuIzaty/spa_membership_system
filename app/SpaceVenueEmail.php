<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceVenueEmail extends Model
{
    use SoftDeletes;

    protected $fillable = ['venue_id','staff_id'];

    public function spaceVenue()
    {
        return $this->hasOne('App\SpaceVenue','id','venue_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id','staff_id');
    }

    public function scopeVenueId($query, $venue_id)
    {
        return $query->where('venue_id',$venue_id);
    }
}

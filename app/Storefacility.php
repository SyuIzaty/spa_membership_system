<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storefacility extends Model
{
    protected $fillable = ['roomfacility_id','roomsuitability_id'];
    protected $table = 'store_facilities';

    public function roomsuitability() 
    {
        return $this->belongsTo('App\Roomsuitability');
    }

    public function roomfacility() 
    {
        return $this->belongsTo('App\Roomfacility');
    }
}

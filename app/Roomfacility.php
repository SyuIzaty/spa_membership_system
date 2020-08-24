<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomfacility extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['code', 'roomtype_id', 'roomsuitability_id', 'name','description','active'];
    protected $table = 'roomfacilities';

    protected $attributes = [
        'active' => 1
    ];

    public function getActiveAttribute($attribute)
    {
        return [
            0 => 'No',
            1 => 'Yes'
        ] [$attribute];
    }

    public function scopeActive($query)
    {
    	return $query->where('active', 1);
    }

    public function scopeInactive($query)
    {
    	return $query->where('active', 0);
    }

    public function roomtype()
    {
        // return $this->belongsTo('App\Roomtype');
        return $this->belongsTo(Roomtype::class);
    }

    public function roomsuitability()
    {
        // return $this->belongsTo('App\Roomsuitability');
        return $this->belongsTo(Roomsuitability::class);
    }
    
}

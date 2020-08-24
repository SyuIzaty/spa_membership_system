<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomtype extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['code','name','description','active'];
    protected $table = 'roomtypes';

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

    public function roomsuitability()
    {
        // return $this->hasMany('App\Roomsuitability');
        return $this->hasMany(Roomsuitability::class);
    }

    public function roomfacility()
    {
    	return $this->hasMany(Roomfacility::class);
    }
    
}


<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomsuitability extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['code', 'roomtype_id', 'name','description','active'];
    protected $table = 'roomsuitabilities';

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

    public function roomfacility()
    {
        // return $this->hasMany('App\Roomfacility');
        return $this->hasMany(Roomfacility::class);
    }

    
}


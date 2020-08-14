<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomsuitability extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['code','name','description','active'];
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

    public function scopeYes($query)
    {
    	return $query->where('active', 1);
    }

    public function scopeNo($query)
    {
    	return $query->where('active', 0);
    }
    
}


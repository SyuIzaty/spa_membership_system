<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['code','name','description','address1','address2','postcode','city','state_id','active'];
    protected $table = 'campuses';

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

    public function zone()
    {
    	return $this->hasMany(Zone::class);
    }

    public function building()
    {
    	return $this->hasMany(Building::class);
    }

    public function level()
    {
    	return $this->hasMany(Level::class);
    }
    
}

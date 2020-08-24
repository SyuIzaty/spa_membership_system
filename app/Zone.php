<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = ['zone_code','campus_id','name','description','active'];
    protected $table = 'zones';

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

    public function campus()
    {
        return $this->belongsTo(Campus::class);
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

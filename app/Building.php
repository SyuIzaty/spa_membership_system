<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    protected $fillable = ['building_code','campus_id','zone_id','name','description','active'];
    protected $table = 'buildings';

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

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function level()
    {
    	return $this->hasMany(Level::class);
    }
}

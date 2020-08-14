<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;

    protected $fillable = ['level_code','campus_id','zone_id','building_id','name','description','active'];
    protected $table = 'levels';

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

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceCondition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status_id',
    ];

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status_id',1);
    }
}

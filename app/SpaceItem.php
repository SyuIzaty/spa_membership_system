<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','description','quantity','status'];

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status');
    }

    public function scopeActive($query)
    {
        return $query->where('status','1');
    }

    public function scopeMain($query)
    {
        return $query->where('category','Main');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceStatus extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','category'];

    public function scopeMain($query)
    {
        return $query->where('category','Main');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'short_name',
        'status_id',
        'color'
    ];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function taskMains()
    {
        return $this->hasOne('App\TaskMain','user_id','id');
    }

    public function scopeActive($query)
    {
        return $query->where('status_id','1');
    }
}

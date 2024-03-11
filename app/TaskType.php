<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'connect_aduan',
        'status_id'
    ];

    public function taskStatus()
    {
        return $this->hasOne('App\TaskStatus','id','status_id');
    }

    public function taskAduanStatus()
    {
        return $this->hasOne('App\TaskStatus','id','connect_aduan');
    }

    public function scopeActive($query)
    {
        return $query->where('status_id',1);
    }
}

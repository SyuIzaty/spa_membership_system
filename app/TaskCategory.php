<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status_id'
    ];

    public function taskStatus()
    {
        return $this->hasOne('App\TaskStatus','id','status_id');
    }
}

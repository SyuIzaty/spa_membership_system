<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category',
        'name',
        'color'
    ];

    public function taskProgresses()
    {
        return $this->hasOne('App\TaskMain','progress_id','id');
    }

    public function scopeCategoryId($query, $category)
    {
        return $query->where('category',$category);
    }
}

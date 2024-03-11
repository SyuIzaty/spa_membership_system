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

    public function scopeCategoryId($query, $category)
    {
        return $query->where('category',$category);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingCategory extends Model
{
    use SoftDeletes;
    protected $table = 'thr_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name'
    ];
}

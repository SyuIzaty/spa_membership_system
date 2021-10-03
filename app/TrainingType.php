<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingType extends Model
{
    use SoftDeletes;
    protected $table = 'thr_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_name'
    ];
}

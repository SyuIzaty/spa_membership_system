<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingType extends Model
{
    use SoftDeletes;
    protected $table = 'trm_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_name'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingHourYear extends Model
{
    use SoftDeletes;
    protected $table = 'trm_hour_year';
    protected $primaryKey = 'id';
    protected $fillable = [
        'year', 'training_hour'
    ];
}

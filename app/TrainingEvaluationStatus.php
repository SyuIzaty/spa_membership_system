<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationStatus extends Model
{
    // use SoftDeletes;
    protected $table = 'trm_evaluation_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'min_point', 'max_point', 'status'
    ];
}

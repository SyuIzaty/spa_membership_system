<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationResult extends Model
{
    use SoftDeletes;
    protected $table = 'thr_evaluation_result';
    protected $primaryKey = 'id';
    protected $fillable = [
        //
    ];
}

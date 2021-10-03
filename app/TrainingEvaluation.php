<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluation extends Model
{
    use SoftDeletes;
    protected $table = 'thr_evaluation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'evaluation', 'open_date', 'close_date', 'is_default'
    ];
}

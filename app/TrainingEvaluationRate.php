<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationRate extends Model
{
    use SoftDeletes;
    protected $table = 'thr_evaluation_rate';
    protected $fillable = ['rate_code', 'rate_name'];
    protected $primaryKey = 'rate_code';

    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationQuestion extends Model
{
    use SoftDeletes;
    protected $table = 'thr_evaluation_question';
    protected $primaryKey = 'id';
    protected $fillable = [
        'evaluation_id', 'head_id', 'question', 'sequence', 'eval_rate'
    ];

    public function trainingEvaluationHeads()
    {
        return $this->hasOne('App\TrainingEvaluationHead','id','head_id');
    }

    public function trainingEvaluation()
    {
        return $this->hasOne('App\TrainingEvaluation','id','evaluation_id');
    }
}

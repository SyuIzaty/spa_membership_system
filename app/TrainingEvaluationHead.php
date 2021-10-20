<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationHead extends Model
{
    use SoftDeletes;
    protected $table = 'trm_evaluation_head';
    protected $primaryKey = 'id';
    protected $fillable = [
        'evaluation_id', 'question_head', 'color', 'sequence'
    ];

    // public function trainingEvaluationQuestions()
    // {
    //     return $this->hasMany('App\TrainingEvaluationQuestion',['head_id','evaluation_id'],['id','evaluation_id']);
    // }

    public function trainingEvaluationQuestions()
    {
        return $this->hasMany('App\TrainingEvaluationQuestion','head_id');
    }

    public function trainingEvaluation()
    {
        return $this->hasOne('App\TrainingEvaluation','id','evaluation_id');
    }

    public function scopeTeId($query, $evaluation_id)
    {
        return $query->where('evaluation_id',$evaluation_id);
    }
}

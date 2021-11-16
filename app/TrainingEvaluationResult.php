<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationResult extends Model
{
    use SoftDeletes;
    protected $table = 'trm_evaluation_result';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id', 'training_id', 'question', 'rating'
    ];

    public function trainingEvaluationQuestion()
    {
        return $this->hasOne('App\TrainingEvaluationQuestion','id','question');
    }

    public function checkResult($id)
    {
        return TrainingEvaluationResult::wherehas('trainingEvaluationQuestion',function($query) use ($id){
            $query->where('evaluation_id',$id);
        })->get()->count();
    }
}

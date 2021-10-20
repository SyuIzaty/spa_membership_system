<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluationHeadResult extends Model
{
    use SoftDeletes;
    protected $table = 'trm_evaluation_head_result';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id', 'training_id', 'evaluation_id', 'submission_status'
    ];

    public function trainingList()
    {
        return $this->hasOne('App\TrainingList','id','training_id');
    }

    public function trainingEvaluation()
    {
        return $this->hasOne('App\TrainingEvaluation','id','evaluation_id');
    }
}

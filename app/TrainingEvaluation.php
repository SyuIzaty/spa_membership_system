<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEvaluation extends Model
{
    use SoftDeletes;
    protected $table = 'trm_evaluation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'evaluation', 'open_date', 'close_date'
    ];

    public function trainingEvaluationHeads()
    {
        return $this->hasMany('App\TrainingEvaluationHead','evaluation_id');
    }

    public function trainingList()
    {
        return $this->hasOne('App\TrainingList','evaluation','id');
    }
}

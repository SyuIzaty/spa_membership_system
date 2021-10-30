<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingList extends Model
{
    use SoftDeletes;
    protected $table = 'trm_training';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'type', 'category', 'start_date', 'end_date', 'venue', 'evaluation', 'evaluation_status', 'upload_image', 'web_path', 
        'start_time', 'end_time', 'claim_hour', 'link'
    ];

    public function types()
    {
        return $this->hasOne('App\TrainingType', 'id', 'type');
    }

    public function categories()
    {
        return $this->hasOne('App\TrainingCategory', 'id', 'category');
    }

    public function evaluations()
    {
        return $this->hasOne('App\TrainingEvaluation', 'id', 'evaluation');
    }
}

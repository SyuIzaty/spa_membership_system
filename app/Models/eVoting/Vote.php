<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use SoftDeletes;
    protected $table = 'evs_vote';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'candidate_id',
        'student_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];
    public function candidate()
    {
        return $this->belongsTo('App\Models\eVoting\Candidate', 'candidate_id', 'id');
    }
}

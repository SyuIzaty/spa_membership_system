<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'evs_candidate';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'tagline',
        'image',
        'voting_session_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];


    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id', 'students_id');
    }
    public function votes()
    {
        return $this->hasMany('App\Models\eVoting\Vote', 'candidate_id', 'id');
    }
    public function voting_session()
    {
        return $this->belongsTo('App\Models\eVoting\VotingSession', 'voting_session_id', 'id');
    }
}

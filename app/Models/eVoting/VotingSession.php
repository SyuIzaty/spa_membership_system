<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingSession extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'evs_voting_session';
    protected $primaryKey = 'id';
    protected $fillable = [
        'session',
        'vote_datetime_start',
        'vote_datetime_end',
        'is_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];


    public function candidates()
    {
        return $this->hasMany('App\Models\eVoting\Candidate', 'voting_session_id', 'id');
    }
    public function candidate_categories()
    {
        return $this->hasMany('App\Models\eVoting\CandidateCategory', 'voting_session_id', 'id');
    }
    public function programme_categories()
    {
        return $this->hasMany('App\Models\eVoting\ProgrammeCategory', 'voting_session_id', 'id');
    }
}

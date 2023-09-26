<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvmVoter extends Model
{
    use SoftDeletes;

    protected $fillable = ['candidate_id','voter_id','voter_programme','voter_session','created_by','updated_by','deleted_by'];

    public function student()
    {
        return $this->hasOne('App\Student','students_id', 'voter_id');
    }

    public function programme()
    {
        return $this->hasOne('App\Programme','id', 'voter_programme');
    }

    public function candidate()
    {
        return $this->hasOne('App\EvmCandidate','id', 'candidate_id');
    }
}

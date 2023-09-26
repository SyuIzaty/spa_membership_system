<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvmProgramme extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id','programme_code','min_vote','max_vote','created_by','updated_by','deleted_by'];

    public function programme()
    {
        return $this->hasOne('App\Programme','id', 'programme_code');
    }

    public function category()
    {
        return $this->hasOne('App\EvmCategory','id', 'category_id');
    }

    public function candidates()
    {
        return $this->hasmany('App\EvmCandidate','programme_id', 'id');
    }
}

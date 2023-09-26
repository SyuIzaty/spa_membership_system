<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvmCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['vote_id','category_name','category_description','created_by','updated_by','deleted_by'];

    public function programmes()
    {
        return $this->hasmany('App\EvmProgramme','category_id', 'id');
    }

    public function vote()
    {
        return $this->hasOne('App\EvmVote','id', 'vote_id');
    }
}

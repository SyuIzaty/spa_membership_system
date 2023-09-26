<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvmVote extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','start_date', 'end_date','created_by','updated_by','deleted_by'];

    public function categories()
    {
        return $this->hasmany('App\EvmCategory','vote_id', 'id');
    }
}

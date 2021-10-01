<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComputerGrantStatus extends Model
{
    protected $table = 'cgm_status';
    protected $primarykey = 'id';
    protected $fillable = ['description'];

    public function application()
    {
        return $this->belongsTo('App\ComputerGrant','status','id');
    }

}


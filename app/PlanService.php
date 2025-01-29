<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanService extends Model
{
    public $timestamps = false;

    protected $fillable = ['plan_id','service_id'];

    public function service()
    {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }
}

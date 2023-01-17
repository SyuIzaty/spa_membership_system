<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['arkib_status', 'arkib_description'];

    public function arkibMains()
    {
        return $this->hasMany('App\ArkibMain','status','arkib_status');
    }
}

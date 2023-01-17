<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibMain extends Model
{
    use SoftDeletes;

    protected $fillable = ['department_code','title','description','status'];

    public function arkibStatus()
    {
        return $this->hasOne('App\ArkibStatus','arkib_status','status');
    }
}

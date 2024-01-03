<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function arkibMains()
    {
        return $this->hasMany('App\ArkibMain','category_id','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatCategory extends Model
{
    protected $table = 'eak_category';
    protected $primarykey = 'id';
    protected $fillable = ['code','description'];

    public function complaint()
    {
        return $this->hasMany('App\AduanKorporat', 'category', 'id');
    }


}


<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanKorporatCategory extends Model
{
    use SoftDeletes;

    protected $table = 'eak_category';
    protected $primarykey = 'id';
    protected $fillable = ['code','description','created_by','updated_by','deleted_by'];

    public function complaint()
    {
        return $this->hasMany('App\AduanKorporat', 'category', 'id');
    }


}


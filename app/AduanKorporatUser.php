<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanKorporatUser extends Model
{
    use SoftDeletes;

    protected $table = 'eak_user_category';
    protected $primarykey = 'id';
    protected $fillable = ['code', 'description','created_by','updated_by','deleted_by'];

    public function complaint()
    {
        return $this->hasMany('App\AduanKorporat', 'user_category', 'code');
    }

}


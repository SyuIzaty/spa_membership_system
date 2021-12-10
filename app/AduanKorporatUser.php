<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatUser extends Model
{
    protected $table = 'eak_user_category';
    protected $primarykey = 'id';
    protected $fillable = ['code', 'description'];

}


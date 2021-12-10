<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatStatus extends Model
{
    protected $table = 'eak_status';
    protected $primarykey = 'id';
    protected $fillable = ['description'];

}


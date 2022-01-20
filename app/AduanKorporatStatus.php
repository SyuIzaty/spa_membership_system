<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanKorporatStatus extends Model
{
    use SoftDeletes;

    protected $table = 'eak_status';
    protected $primarykey = 'id';
    protected $fillable = ['description','created_by','updated_by','deleted_by'];

}


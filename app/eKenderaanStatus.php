<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eKenderaanStatus extends Model
{
    protected $table = 'ekn_status';
    protected $fillable = [
        'name'
    ];
}

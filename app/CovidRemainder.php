<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CovidRemainder extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_remainder';
    protected $dates = ['remainder_date'];
    protected $primaryKey = 'id';
    protected $fillable = [
        'remainder_date', 'status'
    ];
}

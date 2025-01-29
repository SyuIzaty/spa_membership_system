<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = ['discount_name','discount_description','discount_type','discount_value',
                            'discount_start_date','discount_end_date'];
}

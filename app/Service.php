<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = ['service_name','service_description','service_category','service_duration',
                            'service_price','service_img_name','service_img_size','service_img_path'];
}

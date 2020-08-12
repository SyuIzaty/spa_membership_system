<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intakes extends Model
{
    protected $table = 'intakes';

    protected $fillable = [
        'intake_code', 'intake_description', 'intake_app_open', 'intake_app_close', 'intake_check_open', 'intake_check_close', 'status'
    ];
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntakeType extends Model
{
    protected $table = 'intake_types';

    protected $fillable = [
        'intake_type_code', 'intake_type_description',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntakeDetail extends Model
{
    protected $table = 'intake_details';

    protected $fillable = [
        'intake_code', 'intake_date', 'intake_time', 'intake_venue', 'intake_programme', 'intake_programme_description', 'intake_type', 'batch_code'
    ];
}
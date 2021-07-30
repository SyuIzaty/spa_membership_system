<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineChild extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_vaccine_child';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'child_appt', 'child_name', 'first_dose_date', 'second_dose_date'
    ];
}

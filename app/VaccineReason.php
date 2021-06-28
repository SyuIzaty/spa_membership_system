<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineReason extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_vaccine_reason';
    protected $primaryKey = 'id';
    protected $fillable = [
        'reason_name'
    ];
}

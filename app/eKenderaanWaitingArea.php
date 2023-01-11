<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanWaitingArea extends Model
{
    use SoftDeletes;

    protected $table = 'ekn_waiting_area';
    protected $fillable = [
        'ekn_details_id', 'waiting_area', 'created_by', 'updated_by', 'deleted_by'
    ];
}

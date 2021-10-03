<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingStatus extends Model
{
    use SoftDeletes;
    protected $table = 'thr_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_name', 'status_type'
    ];
}

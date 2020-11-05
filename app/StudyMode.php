<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyMode extends Model
{
    use SoftDeletes;

    protected $table = 'study_mode';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mode_code', 'mode_name'
    ];
}

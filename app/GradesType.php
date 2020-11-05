<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradesType extends Model
{
    use SoftDeletes;

    protected $table = 'grades_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'grade_code', 'grade_name'
    ];
}

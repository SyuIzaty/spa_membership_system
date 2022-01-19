<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Config;

class Programme extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'evs_programmes';
    protected $primaryKey = 'id';

    public function programme_category()
    {
        return $this->belongsTo('App\Models\eVoting\ProgrammeCategory', 'programme_category_id', 'id');
    }
    public function students()
    {
        return $this->hasMany('App\Student', 'students_programme', 'code');
    }
}

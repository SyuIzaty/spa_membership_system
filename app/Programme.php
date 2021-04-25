<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'programmes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','programme_series','programme_name','scroll_name','programme_name_malay','scroll_name_malay','programme_duration','programme_status', 'programme_semester'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes;

    protected $table = 'sources';

    protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'source_name',
    ];
}

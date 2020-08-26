<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntakeType extends Model
{
    use SoftDeletes;

    protected $table = 'intake_types';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'intake_type_description',
    ];
}

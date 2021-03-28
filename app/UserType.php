<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_user_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_code', 'user_type'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OauthIcomplaint extends Model
{
    use SoftDeletes;

    protected $connection = 'auth';
    protected $primaryKey = 'id';

    protected $fillable = [
        'google_id' , 'name', 'email'
    ];
}

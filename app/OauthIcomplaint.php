<?php

namespace App;

use Illuminate\Foundation\Auth\iComplaint as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class OauthIcomplaint extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'oauth_icomplaint';
    protected $connection = 'auth';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'id' , 'name', 'email'
    ];
}

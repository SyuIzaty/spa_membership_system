<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as Roles;

class Role extends Roles
{
    protected $connection = 'auth';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id' , 'name', 'guard_name' ,'module'
    ];
}

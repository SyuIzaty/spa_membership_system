<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as Permissions;

class Permission extends Permissions
{
    protected $connection = 'auth';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id' , 'name', 'guard_name' ,'permission'
    ];
}

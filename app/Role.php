<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as Roles;

class Role extends Roles
{
    protected $connection = 'auth';
}

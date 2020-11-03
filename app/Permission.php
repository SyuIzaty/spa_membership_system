<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as Permissions;

class Permission extends Permissions
{
    protected $connection = 'auth';
}

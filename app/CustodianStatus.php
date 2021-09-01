<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustodianStatus extends Model
{
    use SoftDeletes;
    protected $table = 'inv_custodian_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_name'
    ];
}

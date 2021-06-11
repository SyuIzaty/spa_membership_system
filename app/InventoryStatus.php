<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryStatus extends Model
{
    use SoftDeletes;
    protected $table = 'inv_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_name'
    ];
}

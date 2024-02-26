<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceItemMain extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'room_id',
        'category_id',
        'item_id',
        'status_id',
        'total'
    ];
}

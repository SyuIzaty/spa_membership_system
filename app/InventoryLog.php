<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $table = 'inv_logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','description','subject_id','subject_type','properties','creator_id','creator_type'
    ];
}

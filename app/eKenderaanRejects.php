<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanRejects extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_rejects';
    protected $fillable = [
        'ekn_details_id', 'remark', 'category','created_by', 'updated_by', 'deleted_by'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanFeedback extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_feedback';
    protected $fillable = [
        'ekn_details_id', 'remark', 'created_by', 'updated_by', 'deleted_by'
    ];
}

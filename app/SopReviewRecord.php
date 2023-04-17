<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopReviewRecord extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_lists_id','review_record','created_by','updated_by','deleted_by'];
}

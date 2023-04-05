<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopForm extends Model
{
    use SoftDeletes;
    protected $fillable = ['sop_details_id','form','created_by','updated_by','deleted_by'];
}

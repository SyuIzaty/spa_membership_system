<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerGrantFAQ extends Model
{
    use SoftDeletes;
    protected $table = 'cgm_faq';
    protected $primarykey = 'id';
    protected $fillable = ['question', 'answer', 'created_by', 'updated_by', 'deleted_by'];
}

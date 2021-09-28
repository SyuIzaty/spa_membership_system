<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComputerGrantActivityLog extends Model
{
    protected $table = 'cgm_log_activity';
    protected $primarykey = 'id';
    protected $fillable = ['activity', 'created_by'];
}

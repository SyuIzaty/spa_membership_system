<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusAduan extends Model
{
    use SoftDeletes;
    protected $table = 'status_aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kod_status', 'nama_status'
    ];
}

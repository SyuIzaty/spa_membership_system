<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatDepartment extends Model
{
    protected $table = 'eak_department';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'code'
    ];

    public function complaint()
    {
        return $this->hasMany('App\AduanKorporat', 'assign', 'id');
    }

}

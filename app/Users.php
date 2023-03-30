<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id','hp_no','rent_date','return_date','purpose','room_no'
    ];
    public function staff(){
        return $this->hasOne('App\Staff','staff_id','staff_id');
    }
}

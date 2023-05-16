<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RentFile extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $fillable = [
        'users_id','web_path','file'
    ];
    public function equipmentStaff()
    {
        return $this->hasOne('App\EquipmentStaff', 'id', 'users_id');
    }

}
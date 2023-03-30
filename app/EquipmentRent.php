<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EquipmentRent extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $fillable = [
        'users_id','equipments_id','ser_no','desc'
    ];
    public function equipment()
    {
        return $this->hasOne('App\Equipment', 'id', 'equipments_id'); //singular and plural-need to add 's'
    }
    public function equipmentStaff()
    {
        return $this->hasOne('App\EquipmentStaff', 'id', 'users_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentStaff extends Model
{
    use SoftDeletes;
    protected $table = 'equipment_staffs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id', 'hp_no', 'rent_date', 'return_date', 'purpose', 'room_no', 'name', 'status',
    ];
    public function staff()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'staff_id');
    }

    public function equipmentRent()
    {
        return $this->hasMany('App\EquipmentRent', 'users_id', 'id');
    }

}

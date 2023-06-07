<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentFile extends Model
{
    protected $fillable = [
        'users_id', 'web_path', 'file'];

    public function equipmentStaff()
    {
        return $this->hasOne('App\EquipmentStaff','id','users_id');
    }
}

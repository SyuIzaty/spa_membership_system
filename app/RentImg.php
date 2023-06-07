<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentImg extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $fillable = [
        'users_id', 'upload_img', 'web_path'];

    public function equipmentStaff()
    { 
        return $this->hasOne('App\EquipmentStaff','id','users_id');
    }

}

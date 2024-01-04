<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceAttachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'space_main_id',
        'file_name',
        'file_size',
        'web_path',
    ];

    public function spaceBookingMain()
    {
        return $this->hasOne('App\SpaceBookingMain','id','space_main_id');
    }

    public function scopeMainId($query,$space_main_id)
    {
        return $query->where('space_main_id',$space_main_id);
    }
}

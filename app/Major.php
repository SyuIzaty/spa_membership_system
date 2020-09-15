<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;

    protected $table = 'major';

    protected $primaryKey = 'id'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','major_code','major_name','major_status'];

    protected $attributes = [
        'major_status' => 1
    ];

    public function getActiveAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active'
        ] [$attribute];
    }

    public function scopeActive($query)
    {
    	return $query->where('major_status', 1);
    }

    public function scopeInactive($query)
    {
    	return $query->where('major_status', 0);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomowner extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name','phone_number','email','dateofbirth','gender','active','image'];
    protected $table = 'roomowners';

    protected $attributes = [
        'active' => 1
    ];

    public function getActiveAttribute($attribute)
    {
        return [
            0 => 'No',
            1 => 'Yes'
        ] [$attribute];
    }

    public function scopeYes($query)
    {
    	return $query->where('active', 1);
    }

    public function scopeNo($query)
    {
    	return $query->where('active', 0);
    }
}

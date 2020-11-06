<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mode extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'mode_code', 'mode_name'
    ];

    public function major()
    {
        return $this->belongsToMany('App\Programme');
    }
}

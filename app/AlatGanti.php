<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlatGanti extends Model
{
    use SoftDeletes;
    protected $table = 'cms_alat_ganti';
    protected $primaryKey = 'id';
    protected $fillable = [
        'alat_ganti'
    ];
}

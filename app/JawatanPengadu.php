<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawatanPengadu extends Model
{
    use SoftDeletes;
    protected $table = 'jawatan_pengadu';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_jawatan'
    ];
}

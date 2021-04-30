<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlatanPembaikan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_alatan_pembaikan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_aduan', 'alat_ganti'
    ];

    public function alat()
    {
        return $this->hasOne('App\AlatGanti','id','alat_ganti');
    }
}

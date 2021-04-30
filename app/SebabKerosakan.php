<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SebabKerosakan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_sebab_kerosakan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kategori_aduan', 'jenis_kerosakan', 'sebab_kerosakan'
    ];

    public function kategori()
    {
        return $this->hasOne('App\KategoriAduan', 'kod_kategori', 'kategori_aduan');
    }

    public function jenis()
    {
        return $this->hasOne('App\JenisKerosakan', 'id', 'jenis_kerosakan');
    }
}
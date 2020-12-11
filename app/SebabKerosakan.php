<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SebabKerosakan extends Model
{
    use SoftDeletes;
    protected $table = 'sebab_kerosakan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kategori_aduan', 'sebab_kerosakan'
    ];

    public function kategori()
    {
        return $this->hasOne('App\KategoriAduan', 'kod_kategori', 'kategori_aduan');
    }
}
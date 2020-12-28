<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriAduan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_kategori_aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kod_kategori', 'nama_kategori'
    ];
    
}

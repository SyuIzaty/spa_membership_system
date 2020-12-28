<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahapKategori extends Model
{
    use SoftDeletes;
    protected $table = 'cms_tahap_kategori';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kod_tahap', 'jenis_tahap'
    ];
}

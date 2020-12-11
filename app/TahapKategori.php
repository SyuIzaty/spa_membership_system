<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahapKategori extends Model
{
    use SoftDeletes;
    protected $table = 'tahap_kategori';
    protected $primaryKey = 'id';
    protected $fillable = [
        'jenis_tahap'
    ];
}

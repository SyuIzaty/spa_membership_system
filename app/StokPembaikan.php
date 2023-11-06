<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokPembaikan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_stok_pembaikan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_aduan', 'id_stok', 'kuantiti'
    ];

    public function stok()
    {
        return $this->hasOne('App\Stock','id','id_stok');
    }

    public function aduan()
    {
        return $this->hasOne('App\Aduan','id','id_aduan');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JuruteknikBertugas extends Model
{
    use SoftDeletes;
    protected $table = 'cms_juruteknik';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_aduan', 'juruteknik_bertugas', 'jenis_juruteknik'
    ];

    public function juruteknik()
    {
        return $this->hasOne('App\User', 'id', 'juruteknik_bertugas');  
    }

    public function aduan()
    {
        return $this->hasOne('App\Aduan', 'id', 'id_aduan');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComputerGrantType extends Model
{
    protected $table = 'cgm_jenis_pembelian';
    protected $primarykey = 'id';
    protected $fillable = ['description'];
}

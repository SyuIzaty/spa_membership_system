<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImejPembaikan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_imej_pembaikan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_aduan', 'upload_image', 'web_path'
    ];
}

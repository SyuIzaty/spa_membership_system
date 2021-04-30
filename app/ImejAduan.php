<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImejAduan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_imej_aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_aduan', 'upload_image', 'web_path'
    ];
}

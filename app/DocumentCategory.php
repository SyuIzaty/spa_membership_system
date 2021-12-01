<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{

    protected $table = 'dms_category';
    protected $primarykey = 'id';
    protected $fillable = [
        'description'
    ];
}

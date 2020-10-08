<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Migrations\Migration;

class files extends Model
{
    protected $table = 'files';
    protected $fillable = ['id','type','fkey','fkey2','file_name','file_size','web_path','created_at','updated_at'];
    protected $primaryKey = 'id';
    protected $foreignKey = 'fkey';

}

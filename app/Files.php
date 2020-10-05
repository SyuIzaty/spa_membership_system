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
    protected $fillable = ['id','Type','Fkey','Fkey2','File_Name','File_Size','Web_Path','created_at','updated_at'];
    protected $primaryKey = 'id';
    protected $foreignKey = 'Fkey';

}

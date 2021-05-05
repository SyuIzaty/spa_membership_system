<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCategory extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_user_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_code', 'category_name'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusAduan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_status_aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kod_status', 'nama_status', 'color'
    ];

    public function aduan() {
        
        return $this->hasMany('App\Aduan','status_aduan','kod_status');  
    }
}

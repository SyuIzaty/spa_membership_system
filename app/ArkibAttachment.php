<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibAttachment extends Model
{
    use SoftDeletes;

    protected $fillable = ['arkib_main_id','file_name','file_size','web_path'];

    public function arkibMain()
    {
        return $this->hasOne('App\ArkibMain','id','arkin_main_id');
    }

    public function scopeArkibMainId($query, $arkib_main_id)
    {
        return $query->where('arkib_main_id',$arkib_main_id);
    }
}

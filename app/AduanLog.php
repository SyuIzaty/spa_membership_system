<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanLog extends Model
{
    protected $table = 'cms_log';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','description','subject_id','subject_type','properties','creator_id','creator_type'
    ];

    public function staf()
    {
        return $this->hasOne('App\Staff','staff_id','creator_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eKenderaanLog extends Model
{
    protected $table = 'ekn_log';
    protected $primarykey = 'id';
    protected $fillable = ['ekn_details_id','name', 'activity', 'created_by', 'updated_by', 'deleted_by'];

    public function application()
    {
        return $this->hasMany(eKenderaan::class, 'ekn_details_id', 'id');
    }
}

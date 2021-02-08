<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CovidNotes extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_covid_notes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'covid_id', 'follow_up', 'created_by'
    ];

    public function user()
    {
        return $this->hasOne('App\User','id', 'created_by');
    }
}

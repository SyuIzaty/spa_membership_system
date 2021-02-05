<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Covid extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_covid_declarations';
    protected $dates = ['declare_date'];
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'user_phone', 'q1', 'q2', 'q3', 'q4a', 'q4b', 'q4c', 'q4d', 'confirmation', 'category', 'created_by', 'follow_up', 'declare_date'
    ];

    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }
    
}

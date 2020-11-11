<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryRequirement extends Model
{
    public function qualification()
    {
        return $this->hasOne('App\Qualification','qualification_id','qualification_type');
    }

    public function program()
    {
        return $this->hasOne('App\Programme','id','program_code');
    }
}

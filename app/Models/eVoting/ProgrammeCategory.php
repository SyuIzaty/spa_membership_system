<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammeCategory extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'evs_programme_categories';
    protected $primaryKey = 'id';

    public function programmes()
    {
        return $this->hasMany('App\Models\eVoting\Programme', 'programme_category_id', 'id');
    }
    public function candidate_category_programme_category_s()
    {
        return $this->hasMany('App\Models\eVoting\CandidateCategoryProgrammeCategory', 'programme_category_id', 'id');
    }
}

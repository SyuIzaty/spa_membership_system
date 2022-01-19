<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateCategory extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'evs_candidate_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];
    public function candidate_category_programme_category_s()
    {
        return $this->hasMany('App\Models\eVoting\CandidateCategoryProgrammeCategory', 'candidate_category_id', 'id');
    }
}

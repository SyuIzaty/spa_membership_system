<?php

namespace App\Models\eVoting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateCategoryProgrammeCategory extends Model
{
    use SoftDeletes;
    protected $table = 'evs_candidate_category_programme_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'candidate_category_id',
        'programme_category_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];
}

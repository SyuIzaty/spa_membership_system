<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql2';
    protected $table = 'programmes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'mqa_ref_id','programme_name','programme_name_malay', 'accreditation_no', 'accreditation_date', 'compliance_audit', 'validity_period_start',
        'programme_level','mqf_level','nec_field', 'equivalency_ps', 'programme_classification', 'merge','programme_duration','programme_series',
        'credit_hour', 'ad_award', 'award_body', 'instruction_medium', 'programme_semester','grading_method', 'programme_status',
        'programme_type', 'entry_requirement', 'study_method','head_of_programme','remark', 'color', 'pre_registration','ft_long_weeks',
        'ft_long_semesters','ft_durations','ft_short_weeks','ft_short_semesters','pt_long_weeks','pt_long_semesters','pt_durations','pt_short_weeks',
        'pt_short_semesters','credit_hour_graduate', 'validity_period_expiry', 'programme_category', 'shortcourse'
    ];

    protected $attributes = [
        'programme_status' => 1
    ];

    public function getActiveAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active'
        ] [$attribute];
    }

    public function scopeActive($query)
    {
        return $query->where('programme_status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('programme_status', 0);
    }
}

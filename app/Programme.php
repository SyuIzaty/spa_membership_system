<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends Model
{
    use SoftDeletes;

    protected $table = 'programmes';

    protected $primaryKey = 'id'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','programme_code','programme_name','scroll_name','programme_name_malay','scroll_name_malay','programme_duration','programme_status', 
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

    public function applicant()
    {
        $this->belongsTo('App\Applicant','applicant_programme');
    }

}

class Programme2 extends Model
{
    protected $table = 'programmes';
}

class Programme3 extends Model
{
    protected $table = 'programmes';
}

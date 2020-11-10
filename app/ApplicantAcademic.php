<?php

namespace App;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class ApplicantAcademic extends Model
{
    use SoftDeletes;
    protected $table = 'applicant_academic';
    // Set mass-assignable fields
    protected $fillable = ['applicant_id','applicant_study','applicant_year','applicant_major','applicant_cgpa','type','updated_at','created_at'];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant','applicant_id','id');
    }

    public function qualifications()
    {
        return $this->hasOne('App\Qualification','id','type');
    }

    public function scopeApplicantId($query, $id)
    {
        return $query->where('applicant_id',$id);
    }

    public function scopeAlevel($query)
    {
        return $query->where('type','5');
    }

    public function scopeSkm($query)
    {
        return $query->where('type','7');
    }

    public function scopeDiploma($query)
    {
        return $query->where('type','8');
    }

    public function scopeDegree($query)
    {
        return $query->where('type','9');
    }

    public function scopeSace($query)
    {
        return $query->where('type','10');
    }

    public function scopeMuet($query)
    {
        return $query->where('type','11');
    }

    public function scopeMatriculation($query)
    {
        return $query->where('type','12');
    }

    public function scopeFoundation($query)
    {
        return $query->where('type','13');
    }

    public function scopeMqf($query)
    {
        return $query->where('type','14');
    }

    public function scopeKkm($query)
    {
        return $query->where('type','15');
    }

    public function scopeCat($query)
    {
        return $query->where('type','16');
    }

    public function scopeIcaew($query)
    {
        return $query->where('type','17');
    }

    public function scopeIelts($query)
    {
        return $query->where('type','18');
    }

    public function scopeToefl($query)
    {
        return $query->where('type','19');
    }

    public function scopeSvm($query)
    {
        return $query->where('type','20');
    }

    public function scopeApel($query)
    {
        return $query->where('type','21');
    }

    public function file()
    {
        return $this->hasOne('App\Files','fkey','applicant_id');
    }

    public function scopeAcademicAttachment($query, $qualification)
    {
        return $query->with(['file'=>function($query) use ($qualification){
            $query->where('fkey2',$qualification);
        }]);
    }
}

<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;
use App\Permission;

class User extends Authenticatable
{
    protected $connection = 'auth';

    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id' , 'name', 'email', 'password', 'username', 'category'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function aduan()
    {
        return $this->hasMany('App\Aduan','juruteknik_bertugas');
    }

    public function covid()
    {
        return $this->hasMany('App\Covid','user_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id');
    }

    public function trainer()
    {
        return $this->setConnection('mysql')->HasOne('App\Models\ShortCourseManagement\Trainer','user_id','id');
    }

}

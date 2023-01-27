<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibView extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','arkib_attachment_id','total'];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function arkibAttachment()
    {
        return $this->hasOne('App\ArkibAttachment','id','arkib_attachment_id');
    }

    public function scopeUserId($query, $user_id)
    {
        return $query->where('user_id',$user_id);
    }

    public function scopeAttachmentId($query, $attachment_id)
    {
        return $query->where('arkib_attachment_id',$attachment_id);
    }
}

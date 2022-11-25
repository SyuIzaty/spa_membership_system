<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eKenderaanAttachments extends Model
{
    protected $table = 'ekn_attachments';
    protected $fillable = [
        'ekn_details_id', 'upload', 'web_path', 'created_by', 'updated_by', 'deleted_by'
    ];
}

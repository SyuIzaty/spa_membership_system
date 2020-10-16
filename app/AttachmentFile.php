<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentFile extends Model
{
    protected $table = 'attachment_files';

    protected $fillable = ['batch_code', 'file_name', 'file_size', 'web_path'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaimAttachment extends Model
{
    use SoftDeletes;
    protected $table = 'trm_claim_attachment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'claim_id', 'file_name', 'file_size', 'web_path'
    ];
}

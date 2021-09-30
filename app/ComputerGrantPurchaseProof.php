<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerGrantPurchaseProof extends Model
{
    use SoftDeletes;
    protected $table = 'cgm_bukti_pembelian';
    protected $primarykey = 'id';
    protected $fillable = [
        'permohonan_id', 'type', 'upload', 'web_path', 'created_by', 'updated_by', 'deleted_by'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowStatus extends Model
{
    use SoftDeletes;
    protected $table = 'inv_borrower_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_name'
    ];
}

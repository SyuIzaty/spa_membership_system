<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'banks';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = ['id','bank_description', 'bank_address_1','bank_address_2','bank_address_3','bank_contact_person','bank_phone_no','bank_fax_no','bank_account_no'];
}

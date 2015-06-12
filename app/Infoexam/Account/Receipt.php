<?php

namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class Receipt extends Entity
{
    protected $fillable = ['receipt_no', 'receipt_date', 'account_id', 'type'];

    protected $showRemind = false;

    public function user()
    {
        return $this->belongsTo('App\Infoexam\Account\UserDatum', 'recipient', 'id_number');
    }
}

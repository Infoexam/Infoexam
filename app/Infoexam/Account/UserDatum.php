<?php

namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class UserDatum extends Entity
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email'];

    public function account()
    {
        return $this->belongsTo('App\Infoexam\Account\Account');
    }

    public function department()
    {
        return $this->belongsTo('App\Infoexam\Account\Department');
    }
}
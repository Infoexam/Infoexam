<?php namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class UserDatum extends Entity {

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

<?php namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class UserGroup extends Entity {

    protected $fillable = ['account_id', 'group_id'];

    public $timestamps = false;

}

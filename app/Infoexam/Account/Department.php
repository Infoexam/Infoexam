<?php namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class Department extends Entity {

    protected $fillable = ['name', 'code'];

    public $timestamps = false;

}

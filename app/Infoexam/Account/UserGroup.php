<?php

namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class UserGroup extends Entity
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'group_id'];
}

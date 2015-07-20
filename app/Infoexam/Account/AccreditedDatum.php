<?php namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;

class AccreditedDatum extends Entity
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['free_acad', 'free_tech'];
}

<?php namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Entity {

    use SoftDeletes;

    protected $fillable = ['name', 'permissions'];

    protected $dates = ['deleted_at'];

}

<?php

namespace App\Infoexam\Account;

use App\Infoexam\Core\Entity;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Account extends Entity implements AuthenticatableContract
{
    use Authenticatable;

    protected $showRemind = false;

    // 取得使用者個人資料
    public function userData()
    {
        return $this->hasOne('App\Infoexam\Account\UserDatum');
    }

    // 取得使用者成績資料
    public function accreditedData()
    {
        return $this->hasOne('App\Infoexam\Account\AccreditedDatum');
    }

    // 取得使用者所屬群組
    public function groups()
    {
        return $this->belongsToMany('App\Infoexam\Account\Group', 'user_groups');
    }

    // 取得使用者預約過的測驗
    public function applies()
    {
        return $this->hasMany('App\Infoexam\Test\TestApply');
    }

    public function scopeUsername($query, $param)
    {
        $query->where('username', 'like', '%' . $param . '%');
    }

    public function scopeName($query, $param)
    {
        $query->where('name', 'like', '%' . $param . '%');
    }

    public function scopePassed($query, $param)
    {
        $query->where('is_passed', '=', $param);
    }

    public function scopeDepartment($query, $param)
    {
        $query->where('department_id', '=', $param);
    }

    public function getGroupListAttribute()
    {
        return $this->groups->lists('id')->all();
    }

    public function __call($method, $args)
    {
        $callableMethods = ['isAdmin', 'isStudent', 'isInvigilator'];

        if (in_array($method, $callableMethods, true))
        {
            if (null !== ($auth = Auth::user()))
            {
                foreach($auth->groups as $group)
                {
                    $permissions = maybe_unserialize($group->permissions);

                    if ($permissions[$method])
                    {
                        return true;
                    }
                }
            }

            return false;
        }

        return parent::__call($method, $args);
    }
}
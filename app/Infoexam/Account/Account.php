<?php namespace App\Infoexam\Account;

use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class Account extends Model implements AuthenticatableContract {

    use Authenticatable;

    /**
     * Returns the relationship between account and user data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_data()
    {
        return $this->hasOne('App\Infoexam\Account\UserDatum');
    }

    /**
     * Returns the relationship between account and accredited data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function accredited_data()
    {
        return $this->hasOne('App\Infoexam\Account\AccreditedDatum');
    }

    /**
     * Returns the relationship between accounts and groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('App\Infoexam\Account\Group', 'user_groups');
    }

    public function applies()
    {
        return $this->hasMany('App\Infoexam\Student\TestApply');
    }

    public function scopeUsername($query, $param)
    {
        $query->where('accounts.username', 'like', '%'.$param.'%');
    }

    public function scopeName($query, $param)
    {
        $query->where('user_data.name', 'like', '%'.$param.'%');
    }

    public function scopePassed($query, $param)
    {
        $query->where('accredited_data.is_passed', '=', $param);
    }

    public function scopeStudent($query, $param)
    {
        //$query->where('accounts.user_type', (($param) ? '=' : '!='), 'student');
    }

    public function scopeDepartment($query, $param)
    {
        $query->where('user_data.department_id', '=', $param);
    }

    public function getGroupListAttribute()
    {
        return $this->groups->lists('id');
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

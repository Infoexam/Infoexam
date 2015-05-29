<?php namespace App\Http\Middleware;

use Closure;

class UnserializeUserGroupsPermissions {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * 如果使用者已登入，則將使用者所屬群組之權限 unserialize
         */
        if ( ! is_null($auth = \Auth::user()))
        {
            foreach ($auth->groups as $group) {
                $group->permissions = unserialize($group->permissions);
            }
        }

        return $next($request);
    }

}

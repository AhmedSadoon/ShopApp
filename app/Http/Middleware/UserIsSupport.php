<?php

namespace App\Http\Middleware;

use App\Model\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserIsSupport
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=Auth::user();
        $roles=$user->roles;
        $role=Role::find(3);
        foreach ($roles as $role){
            if($role->role=='support')
            {
                return $next($request);
            }

        }

        return redirect(route('home'));
    }
}

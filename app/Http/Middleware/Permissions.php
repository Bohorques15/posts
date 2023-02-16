<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = ["permissions_and"=>[]])
    {
        if(is_string($permissions)){
            $permissions=json_decode($permissions,true);
            $permissions["permissions_and"]=isset($permissions["permissions_and"])?$permissions["permissions_and"]:[];
        }
        $user = User::getCurrent();
        if($user){
            foreach ($permissions["permissions_and"] as $permission) {
                if(!$user->getCurrentRol()->hasPermissionTo($permission)){
                    return redirect()->back()->withErrors(['No tiene los permisos suficientes para ingresar a esta página.']);
                }
            }
        }
        return $next($request);
    }
}

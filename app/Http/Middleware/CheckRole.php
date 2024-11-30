<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {   
        if(\Auth::check()){

            $user = \Auth::user();
            
            if($user->is_admin == 'N'){
                if (!$request->user()->hasAnyRole(explode("|", $roles))) {
                    if($request->ajax()){
                        return response()->json(['status' => 'danger', 'message' => 'Error: Permission access denied!']);
                    }
                    abort(401, 'This action is unauthorized.');
                }
            }
        }
        return $next($request);
    }
}

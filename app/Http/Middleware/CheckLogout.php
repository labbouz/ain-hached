<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\User;

class CheckLogout
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
        $user = Auth::user();

        if ($user) {

            $userUpdatedFlag = User::find($user->id);
            $userUpdatedFlag->logout=false;
            $userUpdatedFlag->save();

            if($user->logout == true ) {
                Auth::logout();
                //return redirect()->route('login');
            }

        }

        return $next($request);
    }
}

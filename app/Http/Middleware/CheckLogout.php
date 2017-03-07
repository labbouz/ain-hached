<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\User;

use Carbon\Carbon;

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

            $date_logout = Carbon::createFromFormat('Y-m-d H:i:s', $userUpdatedFlag->updated_at)->addMinutes(5)->format('Y-m-d H:i:s');
            $date_curent = Carbon::now()->format('Y-m-d H:i:s');

            if( $date_curent <= $date_logout  ) {

                $userUpdatedFlag->logout=false;
                $userUpdatedFlag->save();

                if( $user->logout == true ) {
                    Auth::logout();
                }

            } else {

                if( $user->logout == true ) { //
                    $userUpdatedFlag->logout=false;
                    $userUpdatedFlag->save();
                }

            }

        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

use Route;

use Illuminate\Support\Facades\Auth;

class CheckAuthorisation
{

    private $role_slug;

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

            $roleuser = $user->roleuser;
            $role =  $roleuser->role;
            $this->setRole($role->slug);

            $route_name = Route::currentRouteName();

            if( $this->interditAcces($route_name) ) {


                if ($request->isMethod('POST') || $request->isMethod('PATCH') || $request->isMethod('PUT') || $request->isMethod('DELETE') ){

                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );

                    return response()->json($response);
                } else {
                    return redirect('notacces');
                }



            }
        }


        return $next($request);
    }

    private function setRole($slug){
        $this->role_slug = $slug;
    }

    private function interditAcces($route_name) {

        $tableau_acces=array();

        $tableau_acces['administrator'] = [];
        $tableau_acces['observateur_regional'] = [
            'setting',

            'users.destroy',
            'json.users.indexs',
        ];
        $tableau_acces['observateur_secteur'] = [
            'setting',

            'roles.display',
            'users.display',

            'users.index',
            'users.postavatar',
            'users.create',
            'users.store',
            'users.infosys',
            'users.chnagepass',
            'users.update',
            'users.destroy',
            'json.users.indexs',
        ];
        $tableau_acces['observateur'] = [
            'setting',

            'roles.display',
            'users.display',

            'users.index',
            'users.postavatar',
            'users.create',
            'users.store',
            'users.infosys',
            'users.chnagepass',
            'users.update',
            'users.destroy',
            'json.users.indexs',
        ];

        return in_array($route_name, $tableau_acces[$this->role_slug]);

    }
}

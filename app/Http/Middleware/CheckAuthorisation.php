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

        $tableau_acces = array();

        $admin_acces = array('setting');

        $violations_acces = array('violations.store',
            'violations.index',
            'violations.create',
            'violations.destroy',
            'violations.update',
            'json.violations.index');

        $structure_syndicale_acces = array('structure_syndicale.store',
            'structure_syndicale.index',
            'structure_syndicale.create',
            'structure_syndicale.update',
            'structure_syndicale.destroy',
            'json.structure_syndicale.index');

        $delegations_acces = array('delegations.store',
            'delegations.index',
            'delegations.create',
            'delegations.display',
            'delegations.update',
            'delegations.destroy',
            'json.delegations.index',
            'json.gouvernorats.index');

        $conventions_acces = array('conventions.index',
            'conventions.store',
            'conventions.create',
            'conventions.display',
            'conventions.update',
            'conventions.destroy',
            'json.conventions.index');

        $secteurs_acces = array('secteurs.index',
            'secteurs.store',
            'secteurs.create',
            'secteurs.update',
            'secteurs.destroy',
            'json.secteurs.index');

        $moves_acces = array('moves.index',
            'moves.store',
            'moves.create',
            'moves.destroy',
            'moves.update',
            'json.moves.index');

        $plaintes_acces = array('plaintes.index',
            'plaintes.store',
            'plaintes.create',
            'plaintes.destroy',
            'plaintes.update',
            'json.plaintes.index');

        $medias_acces = array('medias.index',
            'medias.store',
            'medias.create',
            'medias.destroy',
            'medias.update',
            'json.medias.index');

        $type_societe_acces = array('type_societe.store',
            'type_societe.index',
            'type_societe.create',
            'type_societe.update',
            'type_societe.destroy',
            'json.type_societe.index');

        $users_acces = array('roles.display',
            'users.display',
            'users.store',
            'users.index',
            'users.postavatar',
            'users.create',
            'users.infosys',
            'users.chnagepass',
            'users.update',
            'users.destroy',
            'json.users.index',
            'json.observateurs.index');

        $users_acces_observateur_regional = array('roles.display',
            'users.display',
            'users.destroy',
            'json.users.index');

        $societes_admin_acces = array('societes_secteur.admin',
            'societes_region.admin',
            'societes.display.admin');

        $observateur_region_acces = array('societes_secteur.observateur_region',
            'societes_regional.display');

        $observateur_secteur_acces = array('societes_regional.observateur_secteur',
            'societes_sectorial.display');


        /*********************** Roles ***********************/

        $tableau_acces['administrator'] = array_merge(
            $observateur_region_acces,
            $observateur_secteur_acces
        );

        $tableau_acces['observateur_regional'] = array_merge(
            $admin_acces,
            $violations_acces,
            $structure_syndicale_acces,
            $delegations_acces,
            $conventions_acces,
            $secteurs_acces,
            $moves_acces,
            $plaintes_acces,
            $medias_acces,
            $type_societe_acces,
            $societes_admin_acces,
            $observateur_secteur_acces,
            $users_acces_observateur_regional);

        $tableau_acces['observateur_secteur'] = array_merge(
            $admin_acces,
            $violations_acces,
            $structure_syndicale_acces,
            $delegations_acces,
            $conventions_acces,
            $secteurs_acces,
            $moves_acces,
            $plaintes_acces,
            $medias_acces,
            $type_societe_acces,
            $societes_admin_acces,
            $observateur_region_acces,
            $users_acces);

        $tableau_acces['observateur'] = array_merge(
            $admin_acces,
            $violations_acces,
            $structure_syndicale_acces,
            $delegations_acces,
            $conventions_acces,
            $secteurs_acces,
            $moves_acces,
            $plaintes_acces,
            $medias_acces,
            $type_societe_acces,
            $societes_admin_acces,
            $observateur_secteur_acces,
            $users_acces);

        return in_array($route_name, $tableau_acces[$this->role_slug]);

    }
}

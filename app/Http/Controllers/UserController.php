<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Role_user;
use App\Gouvernorat;
use App\Secteur;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::orderBy('id', 'asc')->get();

        return view('roles.users', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayRole($id_role)
    {
        $role = Role::find($id_role);

        switch ($role->slug) {
            case "administrator":
                return view('users.admin', compact('role'));
                break;

            case "observateur_regional":
                $titre_label = trans('users.list_type_observateur_regional');
                $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();
                foreach($gouvernorats as $gouvernorat){
                    $gouvernorat->users_roles = Role_user::where('gouvernorat_id', $gouvernorat->id)
                        ->where('role_id', $role->id)
                        ->orderBy('id', 'desc')
                        ->get();
                }
                return view('gouvernorats.users', compact('role','titre_label','gouvernorats'));
                break;

            case "observateur":
                $titre_label = trans('users.list_type_observateur');
                $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();
                foreach($gouvernorats as $gouvernorat){
                    $gouvernorat->users_roles = Role_user::where('gouvernorat_id', $gouvernorat->id)
                        ->where('role_id', $role->id)
                        ->orderBy('id', 'desc')
                        ->get();
                }
                return view('gouvernorats.users', compact('role','titre_label','gouvernorats'));
                break;

            case "observateur_secteur":
                $titre_label = trans('users.list_type_observateur_secteur');
                $secteures = Secteur::orderBy('id', 'desc')->get();
                foreach($secteures as $secteure){
                    $secteure->users_roles = Role_user::where('secteur_id', $secteure->id)
                        ->where('role_id', $role->id)
                        ->orderBy('id', 'desc')
                        ->get();
                }

                return view('secteures.users', compact('role','titre_label','secteures'));
                break;
        }

    }

    public function display($id_role, $id_inicateur)
    {
        $role = Role::find($id_role);

        switch ($role->slug) {
            case "administrator":
                return view('users.admin', compact('role'));
                break;

            case "observateur_regional":
                $gouvernorat = Gouvernorat::find($id_inicateur);
                return view('users.o_region', compact('role','gouvernorat'));
                break;

            case "observateur":
                $gouvernorat = Gouvernorat::find($id_inicateur);
                return view('users.o', compact('role','gouvernorat'));
                break;

            case "observateur_secteur":
                $secteur = Secteur::find($id_inicateur);
                return view('users.o_sect', compact('role','secteur'));
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'prnom' => 'required|max:255',
            'nom' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id|numeric',
            'gouvernorat_id' => 'required|numeric',
            'secteur_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        // save delegation
        $user_addedd = new User;
        $user_addedd->prnom = $request->prnom;
        $user_addedd->nom = $request->nom;
        $user_addedd->name = $request->prnom . ' ' . $request->nom;
        $user_addedd->email = $request->email;
        $user_addedd->password = bcrypt($request->password);
        $user_addedd->save();

        $roleuser_addedd = new Role_user;
        $roleuser_addedd->role_id = $request->role_id;
        $roleuser_addedd->user_id =  $user_addedd->id;
        $roleuser_addedd->gouvernorat_id = $request->gouvernorat_id;
        $roleuser_addedd->secteur_id = $request->secteur_id;
        $roleuser_addedd->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_save_succes_user'),
        );

        return response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $roleuserUpdated = Role_user::find($id);

        $userUpdated = $roleuserUpdated->user;

        $validator = Validator::make($request->all(), [
            'prnom' => 'required|max:255',
            'nom' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$userUpdated->id.'|max:255'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        // save secteur
        $userUpdated->fill( $request->all() );
        $userUpdated->name = $request->prnom . ' ' . $request->nom;
        $userUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_update_succes_user'),
        );

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roleuserRemoved = Role_user::find($id);

        $userRemoved = $roleuserRemoved->user;

        $roleuserRemoved->delete();
        $userRemoved->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_delete_succes_user'),
        );

        return response()->json($response);
    }


    /**
     * Ajax list
     */

    public function getElementsJSON($id_role, $id_inicateur=null)
    {

        $role = Role::find($id_role);

        $users = $role->users;

        foreach($users as $user){
            $user->name = $user->user->name;
            $user->nom = $user->user->nom;
            $user->prnom = $user->user->prnom;
            $user->email = $user->user->email;
            $user->avatar = $user->user->avatar;
            if($user->avatar  == null) {
                $user->avatar = 'images/avatars/anonyme.jpg';
            }
        }

        $reponse = [
            'status' => 'success',
            'elements' => $users,
        ];

        return response()->json($reponse);
    }

}

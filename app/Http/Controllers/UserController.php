<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Role;
use App\Role_user;
use App\Gouvernorat;
use App\Secteur;
use App\StructureSyndicale;

use Image;
use File;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->isAdmin()) {
            // acces Admin
            $roles = Role::orderBy('id', 'asc')->get();
            return view('roles.users', compact('roles'));

        } else {
            // acces Observateur Regional
            $role = Role::where('slug', 'observateur')->first();

            $id_gouvernorat = Auth::user()->roleuser->gouvernorat_id;
            $gouvernorat = Gouvernorat::find($id_gouvernorat);
            $structures_syndicales = StructureSyndicale::orderBy('type_structure_syndicale', 'asc')->get();
            return view('users.o', compact('role','gouvernorat','structures_syndicales'));

        }




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
                $structures_syndicales = StructureSyndicale::orderBy('type_structure_syndicale', 'asc')->get();
                return view('users.admin', compact('role','structures_syndicales'));
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

        $structures_syndicales = StructureSyndicale::orderBy('type_structure_syndicale', 'asc')->get();

        switch ($role->slug) {
            case "administrator":
                return view('users.admin', compact('role','structures_syndicales'));
                break;

            case "observateur_regional":
                $gouvernorat = Gouvernorat::find($id_inicateur);
                return view('users.o_region', compact('role','gouvernorat','structures_syndicales'));
                break;

            case "observateur":
                $gouvernorat = Gouvernorat::find($id_inicateur);
                return view('users.o', compact('role','gouvernorat','structures_syndicales'));
                break;

            case "observateur_secteur":
                $secteur = Secteur::find($id_inicateur);
                return view('users.o_sect', compact('role','secteur','structures_syndicales'));
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
            'active' => 'required|boolean',
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
        if(Auth::user()->isAdmin()) {
            $user_addedd->active = $request->active;
        } else {
            $user_addedd->active = false;
        }

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
        $oldActive = $userUpdated->active;

        $validator = Validator::make($request->all(), [
            'prnom' => 'required|max:255',
            'nom' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$userUpdated->id.'|max:255',
            'active' => 'required|boolean'
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


        if(Auth::user()->isAdmin()) {
            if($request->active == 1) {
                $userUpdated->active = true;
            } else {
                $userUpdated->active = false;
            }
        } else {
            $userUpdated->active = $oldActive;
        }


        $userUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_update_succes_user'),
        );

        return response()->json($response);
    }

    public function updatePassword(Request $request, $id)
    {
        $roleuserUpdated = Role_user::find($id);

        $userUpdated = $roleuserUpdated->user;

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
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
        $userUpdated->password = bcrypt($request->password);
        $userUpdated->logout = true;
        $userUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_passwordchange_succes_user'),
        );

        return response()->json($response);
    }

    public function updateInfoSystem(Request $request, $id)
    {
        $roleuserUpdated = Role_user::find($id);

        $userUpdated = $roleuserUpdated->user;

        $validator = Validator::make($request->all(), [
            'societe' => 'max:255',
            'structure_syndicale_id' => 'required|numeric',
            'phone_number' => 'numeric|min:8',
            'email2' => 'email|max:255'
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
        $userUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_update_succes_user'),
        );

        return response()->json($response);
    }

    public function updateAvatar(Request $request, $id)
    {

        $roleuserUpdated = Role_user::find($id);

        $userUpdated = $roleuserUpdated->user;

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
        $path = public_path('images/avatars/' . $imageName);
        Image::make($request->avatar->getRealPath())->resize(290, null, function ($constraint) {
            $constraint->aspectRatio();
        })->crop(290, 290, 0, 0)->save($path);

        // delete old Avatar
        if($userUpdated->avatar != null) {
            $old_image_path = public_path('images/avatars/' . $userUpdated->avatar);

            if (File::exists($old_image_path)) {
                //File::delete($image_path);
                unlink($old_image_path);
            }
        }


        // save secteur
        $userUpdated->fill( $request->all() );
        $userUpdated->avatar = $imageName;
        $userUpdated->save();


        $response = array(
            'status' => 'success',
            'msg' => trans('users.message_update_succes_avatar'),
            'avatar' => asset('/images/avatars/' .  $userUpdated->avatar)
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


        if($userRemoved->dossiers->count() == 0) {
            $roleuserRemoved->delete();

            // delete Avatar
            if($userRemoved->avatar != null) {
                $old_image_path = public_path('images/avatars/' . $userRemoved->avatar);

                if (File::exists($old_image_path)) {
                    //File::delete($image_path);
                    unlink($old_image_path);
                }
            }

            $userRemoved->delete();

            $response = array(
                'status' => 'success',
                'msg' => trans('users.message_delete_succes_user'),
            );
        } else {
            $response = array(
                'status' => 'pb_database',
                'msg' => trans('main.problem_delet'),
                'msg_text' => trans('secteur.indication_1_problem_delet'),
            );

        }



        return response()->json($response);
    }


    /**
     * Ajax list
     */

    public function getElementsJSON($id_role, $id_inicateur=null)
    {


        $role = Role::find($id_role); // for admin


        if($role->slug != 'administrator') {
            $role->setIndicateur($id_inicateur);
        }

        $users = $role->deepusers;

        foreach($users as $user){
            $user->name = $user->user->name;
            $user->nom = $user->user->nom;
            $user->prnom = $user->user->prnom;
            $user->email = $user->user->email;
            $user->societe = $user->user->societe;
            $user->structure_syndicale_id = $user->user->structure_syndicale_id;
            $user->phone_number = $user->user->phone_number;
            $user->email2 = $user->user->email2;
            $user->avatar = $user->user->avatar;
            $user->active = $user->user->active;

            if( $user->user->isOnline() ) {
                $user->online = 'on';
                $user->text_online = trans('users.loged_user_online_on');
            } else {
                $user->online = 'off';
                $user->text_online = trans('users.loged_user_online_off');
            }

            if($user->avatar  == null) {
                $user->avatar = 'images/avatars/anonyme.jpg';
            } else {
                $nom_image = $user->avatar;
                $user->avatar = 'images/avatars/' . $nom_image;
            }
        }

        $reponse = [
            'status' => 'success',
            'elements' => $users,
        ];

        return response()->json($reponse);
    }

    public function getElementsJSONviaRegion()
    {

        $role = Role::where('slug', 'observateur')->first();

        // get gouvernorat_id même gouvernorat observateur generale
        $id_inicateur = Auth::user()->roleuser->gouvernorat_id;

        $role->setIndicateur($id_inicateur);

        $users = $role->deepusers;

        foreach($users as $user){
            $user->name = $user->user->name;
            $user->nom = $user->user->nom;
            $user->prnom = $user->user->prnom;
            $user->email = $user->user->email;
            $user->societe = $user->user->societe;
            $user->structure_syndicale_id = $user->user->structure_syndicale_id;
            $user->phone_number = $user->user->phone_number;
            $user->email2 = $user->user->email2;
            $user->avatar = $user->user->avatar;
            $user->active = $user->user->active;

            if( $user->user->isOnline() ) {
                $user->online = 'on';
                $user->text_online = trans('users.loged_user_online_on');
            } else {
                $user->online = 'off';
                $user->text_online = trans('users.loged_user_online_off');
            }

            if($user->avatar  == null) {
                $user->avatar = 'images/avatars/anonyme.jpg';
            } else {
                $nom_image = $user->avatar;
                $user->avatar = 'images/avatars/' . $nom_image;
            }
        }

        $reponse = [
            'status' => 'success',
            'elements' => $users,
        ];

        return response()->json($reponse);
    }

    public function contacts()
    {
        $users = User::orderBy('id', 'desc')->get();

        foreach($users as $user){
            if($user->avatar  == null) {
                $user->avatar = 'images/avatars/anonyme.jpg';
            } else {
                $nom_image = $user->avatar;
                $user->avatar = 'images/avatars/' . $nom_image;
            }

            if( $user->isOnline() ) {
                $user->online = 'on';
                $user->text_online = trans('users.loged_user_online_on');
            } else {
                $user->online = 'off';
                $user->text_online = trans('users.loged_user_online_off');
            }
        }

        $roles = Role::orderBy('id', 'asc')->get();

        $structures_syndicales = Role::orderBy('id', 'asc')->get();
        $gouvernorats = Gouvernorat::orderBy('id', 'asc')->get();
        $secteurs = Secteur::orderBy('id', 'asc')->get();



        return view('users.contacts', compact('users','roles','structures_syndicales','gouvernorats','secteurs'));
    }

}

<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;


use App\Secteur;
use App\Role_user;
//use App\Convention;

class SecteurController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('secteures.index');
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
            'nom_secteur' => 'required|unique:secteurs,nom_secteur|max:255',
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
        $secteuradedd = new Secteur;
        $secteuradedd->nom_secteur = $request->nom_secteur;
        $secteuradedd->save();

        $secteuradedd->count_conventions = 0;
        $secteuradedd->description_count_conventions = trans('secteur.not_exist_conventions_sectorielles_conjointes');



        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_save_succes_secteur')
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

        $secteurUpdated = Secteur::find($id);

        $validator = Validator::make($request->all(), [
            'nom_secteur' => 'required|unique:secteurs,nom_secteur,'.$secteurUpdated->id.'|max:255',
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
        $secteurUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_update_succes_secteur'),
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
        $secteurRemoved = Secteur::find($id);

        if( $secteurRemoved->conventions->count() == 0 ) {


            $uesers_secteur = Role_user::where('secteur_id', $secteurRemoved->id)
                ->orderBy('id', 'desc')
                ->get();

            if( $uesers_secteur->count() == 0 && $secteurRemoved->societes->count() == 0 ) {

                $secteurRemoved->delete();
                $response = array(
                    'status' => 'success',
                    'msg' => trans('secteur.message_delete_succes_secteur'),
                );

            } else {
                $response = array(
                    'status' => 'pb_database',
                    'msg' => trans('main.problem_delet'),
                    'msg_text' => trans('secteur.indication_2_problem_delet'),
                );
            }

        } else {
            $response = array(
                'status' => 'pb_database',
                'msg' => trans('main.problem_delet'),
                'msg_text' => trans('secteur.indication_1_problem_delet'),
            );
        }

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        //$secteures = Secteur::all();
        $secteures = Secteur::orderBy('id', 'desc')->get();

        foreach($secteures as $secteure){

            $count_convention=0;
            $text_list_convention='';
            foreach($secteure->conventions as $convention) {
                if($secteure->conventions->first() == $convention) {
                    $text_list_convention .= $convention->nom_convention;
                } else {
                    $text_list_convention .= ' - ' . $convention->nom_convention;
                }

                $count_convention++;
            }

            $secteure->count_conventions = $count_convention;
            if($count_convention == 0) {
                $secteure->description_count_conventions = trans('secteur.not_exist_conventions_sectorielles_conjointes');
            } else {
                $secteure->description_count_conventions = trans('secteur.la_conventions_sectorielles_conjointes') . ' ' . trans('secteur.pour_secteur') . ' ' . $secteure->nom_secteur . ' : ' . $text_list_convention;
            }

            /************************/
            $uesers_secteur = Role_user::where('secteur_id', $secteure->id)
                ->orderBy('id', 'desc')
                ->get();

            $count_users=0;
            $text_list_users='';
            foreach($uesers_secteur as $roleuser) {
                if($count_users == 0) {
                    $text_list_users .= $roleuser->user->name;
                } else {
                    $text_list_users .= ' - ' . $roleuser->user->name;
                }
                $count_users++;
            }
            $secteure->count_users = $count_users;
            if($count_users == 0) {
                $secteure->description_count_users = trans('secteur.not_exist_users');
            } else {
                $secteure->description_count_users = $text_list_users;
            }
            /***************************/



            $secteure->url_display_conventions = route('conventions.display',$secteure->id );

        }


        $reponse = [
            'status' => 'success',
            'elements' => $secteures,
        ];

        return response()->json($reponse);
    }
}

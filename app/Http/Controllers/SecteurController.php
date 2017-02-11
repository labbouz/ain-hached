<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;


use App\Secteur;
//use App\Convention;

class SecteurController extends Controller
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
        return view('secteures.index', compact('users'));
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
        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_save_succes_secteur'),
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
        Secteur::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_delete_succes_secteur'),
        );

        return response()->json($response);
    }

    public function getUsersJSON()
    {

        //$secteures = Secteur::all();
        $secteures = Secteur::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $secteures,
        ];

        return response()->json($reponse);
    }
}

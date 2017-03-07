<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use App\Convention;
use App\Secteur;

class ConventionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function display($id_secteur)
    {
        $secteur = Secteur::find($id_secteur);

        return view('conventions.index', compact('secteur'));
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
            'nom_convention' => 'required|unique:conventions,nom_convention|max:255',
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
        $convention_adedd = new Convention;
        $convention_adedd->nom_convention = $request->nom_convention;
        $convention_adedd->secteur_id = $request->secteur_id;
        $convention_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_save_succes_convention'),
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
        $conventionUpdated = Convention::find($id);

        $validator = Validator::make($request->all(), [
            'nom_convention' => 'required|unique:conventions,nom_convention,'.$conventionUpdated->id.'|max:255',
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

        // save secteur
        $conventionUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_update_succes_convention'),
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
        Convention::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('secteur.message_delete_succes_convention'),
        );

        return response()->json($response);
    }

    public function getElementsJSON($id_secteur)
    {

        $secteur = Secteur::find($id_secteur);

        $conventions = $secteur->conventions;

        $reponse = [
            'status' => 'success',
            'elements' => $conventions,
        ];

        return response()->json($reponse);
    }
}

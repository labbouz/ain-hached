<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use Auth;

use App\Secteur;
use App\Gouvernorat;
use App\Societe;
use App\Dossier;

class DossierController extends Controller
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

    public function showDossiers($id_societe)
    {
        //return view('dossiers.index', compact('types_violations','gravites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        switch (Auth::user()->getRole()) {
            case "administrator":
                $secteures = Secteur::orderBy('id', 'desc')->get();
                $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();
                return view('dossiers.add.admin', compact('secteures', 'gouvernorats'));
                break;

            case "observateur_regional":
            case "observateur":
                $secteures = Secteur::orderBy('id', 'desc')->get();
                $gouvernorat = Gouvernorat::find(Auth::user()->roleuser->gouvernorat_id);
                return view('dossiers.add.admin', compact('secteures','gouvernorat'));
                break;

            case "observateur_secteur":
                $secteur = Secteur::find(Auth::user()->roleuser->secteur_id);
                $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();
                return view('dossiers.add.admin', compact('secteur','gouvernorats'));
                break;
        }
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
            'societe_id' => 'required|numeric|exists:societes,id'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        $societeAddedFile = Societe::find($request->societe_id);


        // controle droits

        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                if( $societeAddedFile->delegation->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                        'msg_text' => '',
                    );
                    return response()->json($response);
                }
                break;

            case "observateur_secteur":
                if( $societeAddedFile->secteur_id != Auth::user()->roleuser->secteur_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                        'msg_text' => '',
                    );
                    return response()->json($response);
                }

                break;
        }

        // save delegation
        $dossier_adedd = new Dossier;
        $dossier_adedd->societe_id = $societeAddedFile->id;
        $dossier_adedd->created_by = Auth::user()->id;
        $dossier_adedd->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('dossier.message_save_succes_dossier') . ' ' . sprintf("%05d", $dossier_adedd->id),
            'msg_text' => trans('dossier.message_desc_save_succes_dossier'). '<br><br><strong>' . $societeAddedFile->nom_societe.'</strong>',
            'id' => $dossier_adedd->id
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
        $dossier = Dossier::find($id);

        echo 'Nom societe = ' . $dossier->societe->nom_societe;
        echo 'Nom createur = ' . $dossier->user->name;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

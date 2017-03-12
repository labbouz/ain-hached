<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use Auth;

use App\Secteur;
use App\Gouvernorat;
use App\Delegation;
use App\Societe;
use App\TypeSociete;

class SocieteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        switch (Auth::user()->getRole()) {
            case "administrator":
                $secteures = Secteur::orderBy('id', 'desc')->get();
                return view('secteures.societes', compact('secteures'));
                break;

            case "observateur_regional":
            case "observateur":
                //return view('users.o', compact('role','gouvernorat','structures_syndicales'));
                break;

            case "observateur_secteur":
                //return view('users.o_sect', compact('role','secteur','structures_syndicales'));
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
            'nom_societe' => 'required|unique:societes,nom_societe|max:255',
            'nom_marque' => 'max:255',
            'type_societe_id' => 'required|numeric',
            'date_cration_societe' => 'date|date_format:Y-m-d',
            'delegation_id' => 'required|numeric',
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
        $societe_adedd = new Societe;
        $societe_adedd->nom_societe = $request->nom_societe;
        $societe_adedd->nom_marque = $request->nom_marque;
        $societe_adedd->type_societe_id = $request->type_societe_id;
        $societe_adedd->date_cration_societe = $request->date_cration_societe;
        $societe_adedd->delegation_id = $request->delegation_id;
        $societe_adedd->secteur_id = $request->secteur_id;
        $societe_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('societe.message_save_succes_societe'),
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

    public function showRegionByAdmin($id_secteur)
    {
        $secteur = Secteur::find($id_secteur);

        if(!$secteur) {
            return redirect('error');
        }

        $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();

        foreach($gouvernorats as $gouvernorat){

            $count_societes=0;
            foreach($gouvernorat->delegations as $delegation) {
                $delegation->setSecteur($secteur->id);
                $count_societes += $delegation->societesViaSecteur->count();
            }

            $gouvernorat->nb_societes = $count_societes;
        }

        return view('gouvernorats.societes', compact('secteur','gouvernorats'));
    }

    public function showDelegationByAdmin($id_secteur, $id_gouvernorat)
    {
        $secteur = Secteur::find($id_secteur);

        $gouvernorat = Gouvernorat::find($id_gouvernorat);

        if(!$gouvernorat || !$secteur) {
            return redirect('error');
        }

        return view('delegations.societes', compact('secteur','gouvernorat'));
    }

    public function showSocietesByAdmin($id_secteur, $id_delegation)
    {
        $secteur = Secteur::find($id_secteur);
        $delegation = Delegation::find($id_delegation);

        if(!$secteur || !$delegation) {
            return redirect('error');
        }

        $types_societes = TypeSociete::orderBy('id', 'asc')->get();

        //set croisment
        $delegation->setSecteur($secteur->id);

        return view('societes.index', compact('secteur','delegation','types_societes'));
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

    public function getElementsJSONviaRegion($id_secteur, $id_delegation)
    {

        $secteur = Secteur::find($id_secteur);

        $delegation = Delegation::find($id_delegation);

        if(!$secteur || !$delegation) {
            $response = array(
                'status' => 'notacces',
                'msg' => trans('main.errors'),
            );

            return response()->json($response);
        }

        //set croisment
        $delegation->setSecteur($secteur->id);

        $societes = $delegation->societesViaSecteur;

        $reponse = [
            'status' => 'success',
            'elements' => $societes,
        ];

        return response()->json($reponse);
    }
}

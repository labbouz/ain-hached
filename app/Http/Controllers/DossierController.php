<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use Auth;

use App\Secteur;
use App\Gouvernorat;
use App\Delegation;
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
        //
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Secteur;
use App\Gouvernorat;

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

    public function showRegionByAdmin($id_secteur)
    {
        $secteur = Secteur::find($id_secteur);
        $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();


        foreach($gouvernorats as $gouvernorat){

            $count_societes=0;
            foreach($gouvernorat->delegations as $delegation) {
                $count_societes += $delegation->societes->count();
            }

            $gouvernorat->nb_societes = $count_societes;
        }

        return view('gouvernorats.societes', compact('secteur','gouvernorats'));
    }

    public function showDelegationByAdmin($id_secteur, $id_gouvernorat)
    {
        $secteur = Secteur::find($id_secteur);
        $gouvernorat = Gouvernorat::find($id_gouvernorat);

        return view('delegations.societes', compact('secteur','gouvernorat'));
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

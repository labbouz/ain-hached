<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use DB;

use App\Delegation;
use App\Gouvernorat;

class DelegationController extends Controller
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
        $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();

        return view('gouvernorats.delegations', compact('gouvernorats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function display($id_gouvernorat)
    {
        $gouvernorat = Gouvernorat::find($id_gouvernorat);

        return view('delegations.index', compact('gouvernorat'));
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
            'nom_delegation' => 'required|unique:delegations,nom_delegation|max:255',
            'gouvernorat_id' => 'required|numeric'
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
        $delegation_adedd = new Delegation;
        $delegation_adedd->nom_delegation = $request->nom_delegation;
        $delegation_adedd->gouvernorat_id = $request->gouvernorat_id;
        $delegation_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('delegations.message_save_succes_delegation'),
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
        $delegationUpdated = Delegation::find($id);

        $validator = Validator::make($request->all(), [
            'nom_delegation' => 'required|unique:delegations,nom_delegation,'.$delegationUpdated->id.'|max:255',
            'gouvernorat_id' => 'required|numeric'
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
        $delegationUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('delegations.message_update_succes_delegation'),
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
        Delegation::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('delegations.message_delete_succes_delegation'),
        );

        return response()->json($response);
    }

    public function getElementsJSON($id_gouvernorat)
    {

        $gouvernorat = Gouvernorat::find($id_gouvernorat);

        $delegations = $gouvernorat->delegations;

        $reponse = [
            'status' => 'success',
            'elements' => $delegations,
        ];

        return response()->json($reponse);
    }
}

<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Abus;
use App\Dossier;

class AbusController extends Controller
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
            'violation_id' => 'required|numeric',
            'dossier_id' => 'required|numeric',
            'date_violation' => 'required|date_format:d/m/Y',
            'statut_reglement' => 'required|numeric'

        ]);


        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => $request->date_violation . ' - ' . trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        // Controle date if empty
        if($request->date_violation == '') {
            $request->date_violation = null;
        } else {
            $date_fr = explode('/', $request->date_violation );
            $request->date_violation = $date_fr[2].'-'.$date_fr[1].'-'.$date_fr[0];
        }

        // save secteur
        $abus_adedd = new Abus;
        $abus_adedd->violation_id = $request->violation_id;
        $abus_adedd->dossier_id = $request->dossier_id;
        $abus_adedd->date_violation = $request->date_violation;
        $abus_adedd->statut_reglement = $request->statut_reglement;
        $abus_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_save_succes_abus'),
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
        echo "Detail Abus = " . $id;
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
        $abusUpdated = Abus::find($id);

        $validator = Validator::make($request->all(), [
            'date_violation' => 'required|date_format:d/m/Y',
            'statut_reglement' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        // Controle date if empty
        if($request->date_violation == '') {
            $request->date_violation = null;
        } else {
            $date_fr = explode('/', $request->date_violation );
            $request->date_violation = $date_fr[2].'-'.$date_fr[1].'-'.$date_fr[0];
        }

        // save secteur
        $abusUpdated->date_violation = $request->date_violation;
        $abusUpdated->statut_reglement = $request->statut_reglement;

        $abusUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_update_succes_abus'),
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
        $abusDeleted = Abus::find($id);

        /*
        if($abusDeleted->dossiers->count() > 0) {
            $response = array(
                'status' => 'pb_database',
                'msg' => trans('main.problem_delet'),
                'msg_text' => trans('abus.indication_1_problem_delet'),
            );
        } else {
            $abusDeleted->delete();

            $response = array(
                'status' => 'success',
                'msg' => trans('abus.message_delete_succes_abus'),
            );
        }
        */

        $abusDeleted->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_delete_succes_abus'),
        );

        return response()->json($response);
    }


    public function getElementsJSON($id_dossier)
    {

        if(!$id_dossier) {
            $response = array(
                'status' => 'notacces',
                'msg' => trans('main.errors'),
            );

            return response()->json($response);
        }

        $dossier = Dossier::find($id_dossier);

        $abus = $dossier->abus;

        foreach ($abus as $abu) {
            $abu->nom_violation = $abu->violation->nom_violation;

            $abu->nom_type_violation = $abu->violation->type_violation->nom_type_violation;
            $abu->class_color_type_violation = $abu->violation->type_violation->class_color_type_violation;

            $abu->	nom_gravite = $abu->violation->gravite->nom_gravite;
            $abu->	class_color_gravite = $abu->violation->gravite->class_color_gravite;

            $abu->nb_confrontations_moves = 0;
            $abu->nb_confrontations_plaintes = 0;
            $abu->nb_confrontations_medias = 0;

            if($abu->date_violation != null && $abu->date_violation != '') {
                $date_fr = explode('-', $abu->date_violation );
                $abu->date_violation = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }

        }


        $reponse = [
            'status' => 'success',
            'elements' => $abus
        ];

        return response()->json($reponse);
    }
}

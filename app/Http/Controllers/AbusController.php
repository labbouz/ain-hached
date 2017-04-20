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
            'date_violation' => 'date|date_format:d/m/Y',
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
            'date_violation' => 'date|date_format:d/m/Y',
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


        /*
        foreach ($abus as $abu) {
            $societe->nb_dossiers = $societe->dossiers->count();
            $societe->url_show_dossiers = route('societe.show.dossiers', $societe->id);

            if($societe->date_cration_societe != null && $societe->date_cration_societe != '') {
                $date_fr = explode('-', $societe->date_cration_societe );
                $societe->date_cration_societe = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }

        }
        */

        $reponse = [
            'status' => 'success',
            'elements' => $abus
        ];

        return response()->json($reponse);
    }
}

<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Abus;
use App\Endommage;
use App\Agresseur;

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
            'statut_reglement' => 'required|numeric',

            'prenom_endommage' => 'required',
            'nom_endommage' => 'required',
            'structure_syndicale_id' => 'required|numeric',
            'genre' => 'required',
            'age' => 'required|numeric',
            'etat_civile' => 'numeric',
            'nb_enfant' => 'numeric',
            'phone_number' => 'required|numeric',
            'email' => 'email',
            'type_contrat' => 'required|numeric',
            'anciennete' => 'required|numeric',

            'prenom_agresseur' => 'max:255',
            'nom_agresseur' => 'max:255',
            'nationalite' => 'max:255',
            'responsabilite_1' => 'required|numeric',
            'responsabilite_2' => 'required|numeric',
            'responsabilite_3' => 'required|numeric'
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

        $endommage_addedd = new Endommage;
        $endommage_addedd->abus_id = $abus_adedd->id;
        $endommage_addedd->structure_syndicale_id = $request->structure_syndicale_id;
        $endommage_addedd->nom = $request->prenom_endommage;
        $endommage_addedd->prenom = $request->prenom_endommage;
        $endommage_addedd->genre = $request->genre;
        $endommage_addedd->age =  $request->age;
        $endommage_addedd->etat_civile = $request->etat_civile;
        $endommage_addedd->nb_enfant = intval($request->nb_enfant);
        $endommage_addedd->phone_number = $request->phone_number;
        $endommage_addedd->email =  $request->email;
        $endommage_addedd->type_contrat = $request->type_contrat;
        $endommage_addedd->anciennete = $request->anciennete;
        $endommage_addedd->save();

        $agresseur_addedd = new Agresseur;
        $agresseur_addedd->abus_id = $abus_adedd->id;
        $agresseur_addedd->nom = $request->nom_agresseur;
        $agresseur_addedd->prenom = $request->prenom_agresseur;
        $agresseur_addedd->nationalite = $request->nationalite;
        $agresseur_addedd->responsabilite_1 = $request->responsabilite_1;
        $agresseur_addedd->responsabilite_2 = $request->responsabilite_1;
        $agresseur_addedd->responsabilite_3 = $request->responsabilite_1;
        $agresseur_addedd->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_save_succes_abus'),
        );

        return response()->json($response);
    }


    public function store2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'violation_id' => 'required|numeric',
            'dossier_id' => 'required|numeric',
            'date_violation' => 'required|date_format:d/m/Y',
            'statut_reglement' => 'required|numeric',

            'structure_syndicale_id' => 'required|numeric',

            'prenom_agresseur' => 'max:255',
            'nom_agresseur' => 'max:255',
            'nationalite' => 'max:255',
            'responsabilite_1' => 'required|numeric',
            'responsabilite_2' => 'required|numeric',
            'responsabilite_3' => 'required|numeric'
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

        $endommage_addedd = new Endommage;
        $endommage_addedd->abus_id = $abus_adedd->id;
        $endommage_addedd->structure_syndicale_id = $request->structure_syndicale_id;
        $endommage_addedd->nom = '';
        $endommage_addedd->prenom = '';
        $endommage_addedd->genre = '';
        $endommage_addedd->age =  0;
        $endommage_addedd->etat_civile = 0;
        $endommage_addedd->nb_enfant = 0;
        $endommage_addedd->phone_number = '';
        $endommage_addedd->email =  '';
        $endommage_addedd->type_contrat = 0;
        $endommage_addedd->anciennete = 0;
        $endommage_addedd->save();

        $agresseur_addedd = new Agresseur;
        $agresseur_addedd->abus_id = $abus_adedd->id;
        $agresseur_addedd->nom = $request->nom_agresseur;
        $agresseur_addedd->prenom = $request->prenom_agresseur;
        $agresseur_addedd->nationalite = $request->nationalite;
        $agresseur_addedd->responsabilite_1 = $request->responsabilite_1;
        $agresseur_addedd->responsabilite_2 = $request->responsabilite_1;
        $agresseur_addedd->responsabilite_3 = $request->responsabilite_1;
        $agresseur_addedd->save();

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


        if($abusUpdated->violation->type_violation_id == 1) {
            $array_rules = [
                'date_violation' => 'required|date_format:d/m/Y',
                'statut_reglement' => 'required|numeric',

                'prenom_endommage' => 'required',
                'nom_endommage' => 'required',
                'structure_syndicale_id' => 'required|numeric',
                'genre' => 'required',
                'age' => 'required|numeric',
                'etat_civile' => 'numeric',
                'nb_enfant' => 'numeric',
                'phone_number' => 'required|numeric',
                'email' => 'email',
                'type_contrat' => 'required|numeric',
                'anciennete' => 'required|numeric'
            ];
        } else { // $abusUpdated->violation->type_violation_id == 2
            $array_rules = [
                'date_violation' => 'required|date_format:d/m/Y',
                'statut_reglement' => 'required|numeric',
                'structure_syndicale_id' => 'required|numeric'
            ];
        }

        $validator = Validator::make($request->all(), $array_rules);

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
        $abusUpdated->endommage->structure_syndicale_id = $request->structure_syndicale_id;

        if($abusUpdated->violation->type_violation_id == 1) {
            $abusUpdated->endommage->prenom = $request->prenom_endommage;
            $abusUpdated->endommage->nom = $request->nom_endommage;
            $abusUpdated->endommage->genre = $request->genre;
            $abusUpdated->endommage->age = $request->age;
            $abusUpdated->endommage->etat_civile = $request->etat_civile;
            $abusUpdated->endommage->nb_enfant = $request->nb_enfant;
            $abusUpdated->endommage->phone_number = $request->phone_number;
            $abusUpdated->endommage->email = $request->email;
            $abusUpdated->endommage->type_contrat = $request->type_contrat;
            $abusUpdated->endommage->anciennete = $request->anciennete;
        }

        $abusUpdated->endommage->save();
        $abusUpdated->save();

        if(strlen($abusUpdated->endommage->nom)>0) {
            $info_endommage = $abusUpdated->endommage->nom . ' ' . $abusUpdated->endommage->prenom . ' / ' . $abusUpdated->endommage->structure_syndicale->type_structure_syndicale;
        } else {
            $info_endommage = $abusUpdated->endommage->structure_syndicale->type_structure_syndicale;
        }

        if($abusUpdated->statut_reglement) {
            $resultat_violation = trans('abus.resultat') . ' : ' . trans('abus.resultat_ok');
        } else {
            $resultat_violation = trans('abus.resultat') . ' : ' . trans('abus.resultat_not_ok');
        }

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_update_succes_abus'),
            'info_endommage' => $info_endommage,
            'resultat_violation' => $resultat_violation
        );

        return response()->json($response);
    }

    public function updateAgresseur(Request $request, $id)
    {
        $abusUpdated = Abus::find($id);

        $validator = Validator::make($request->all(), [
            'prenom_agresseur' => 'max:255',
            'nom_agresseur' => 'max:255',
            'nationalite' => 'max:255',
            'responsabilite_1' => 'required|numeric',
            'responsabilite_2' => 'required|numeric',
            'responsabilite_3' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        $abusUpdated->agresseur->nom = $request->nom_agresseur;
        $abusUpdated->agresseur->prenom = $request->prenom_agresseur;
        $abusUpdated->agresseur->nationalite = $request->nationalite;
        $abusUpdated->agresseur->responsabilite_1 = $request->responsabilite_1;
        $abusUpdated->agresseur->responsabilite_2 = $request->responsabilite_2;
        $abusUpdated->agresseur->responsabilite_3 = $request->responsabilite_3;
        $abusUpdated->agresseur->save();


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

        $abusDeleted->endommage->delete();
        $abusDeleted->agresseur->delete();
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

            $abu->id_type_violation = $abu->violation->type_violation->id;
            $abu->nom_type_violation = $abu->violation->type_violation->nom_type_violation;
            $abu->class_color_type_violation = $abu->violation->type_violation->class_color_type_violation;

            $abu->nom_gravite = $abu->violation->gravite->nom_gravite;
            $abu->class_color_gravite = $abu->violation->gravite->class_color_gravite;

            $abu->nb_confrontations_moves = $abu->accrochages_moves->count();
            $abu->nb_confrontations_plaintes = $abu->accrochages_plaintes->count();
            $abu->nb_confrontations_medias = $abu->accrochages_medias->count();

            $abu->url_accrochages_moves = route('abus.moves', ['abus' => $abu]);
            $abu->url_accrochages_plaintes = route('abus.plaintes', ['abus' => $abu]);
            $abu->url_accrochages_medias = route('abus.medias', ['abus' => $abu]);

            if($abu->date_violation != null && $abu->date_violation != '') {
                $date_fr = explode('-', $abu->date_violation );
                $abu->date_violation = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }

            if($abu->statut_reglement) {
                $abu->resultat_violation = trans('abus.resultat') . ' : ' . trans('abus.resultat_ok');
            } else {
                $abu->resultat_violation = trans('abus.resultat') . ' : ' . trans('abus.resultat_not_ok');
            }

            // endommage
            if(strlen($abu->endommage->nom)>0) {
                $abu->info_endommage = $abu->endommage->nom . ' ' . $abu->endommage->prenom . ' / ' . $abu->endommage->structure_syndicale->type_structure_syndicale;
            } else {
                $abu->info_endommage = $abu->endommage->structure_syndicale->type_structure_syndicale;
            }


            // info endommage
            $abu->structure_syndicale_id = $abu->endommage->structure_syndicale_id;
            $abu->prenom_endommage = $abu->endommage->prenom;
            $abu->nom_endommage = $abu->endommage->nom;
            $abu->genre = $abu->endommage->genre;
            $abu->age =  $abu->endommage->age;
            $abu->etat_civile = $abu->endommage->etat_civile;
            $abu->nb_enfant = $abu->endommage->nb_enfant;
            $abu->phone_number = $abu->endommage->phone_number;
            $abu->email = $abu->endommage->email;
            $abu->type_contrat = $abu->endommage->type_contrat;
            $abu->anciennete = $abu->endommage->anciennete;


            // info agresseur
            $abu->prenom_agresseur = $abu->agresseur->prenom;
            $abu->nom_agresseur = $abu->agresseur->nom;
            $abu->nationalite = $abu->agresseur->nationalite;
            $abu->responsabilite_1 = $abu->agresseur->responsabilite_1;
            $abu->responsabilite_2 = $abu->agresseur->responsabilite_2;
            $abu->responsabilite_3 = $abu->agresseur->responsabilite_3;

        }


        $reponse = [
            'status' => 'success',
            'elements' => $abus
        ];

        return response()->json($reponse);
    }
}

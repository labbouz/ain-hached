<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use DB;

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
                $secteures = Secteur::orderBy('id', 'desc')->get();
                $gouvernorat = Gouvernorat::find(Auth::user()->roleuser->gouvernorat_id);
                foreach ($secteures as $secteure) {

                    $count_societes = DB::table('societes')
                        ->join('delegations', 'delegations.id', '=', 'societes.delegation_id')
                        ->join('gouvernorats', 'gouvernorats.id', '=', 'delegations.gouvernorat_id')
                        ->select('societes.*')
                        ->where('societes.secteur_id', '=', $secteure->id)
                        ->where('gouvernorats.id', '=', $gouvernorat->id)
                        ->count();

                    $secteure->nb_societes = $count_societes ;
                }
                return view('secteures.societes_or', compact('secteures','gouvernorat'));
                break;

            case "observateur_secteur":
                $secteur = Secteur::find(Auth::user()->roleuser->secteur_id);
                $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();

                foreach($gouvernorats as $gouvernorat){

                    $count_societes=0;
                    foreach($gouvernorat->delegations as $delegation) {
                        $delegation->setSecteur($secteur->id);
                        $count_societes += $delegation->societesViaSecteur->count();
                    }

                    $gouvernorat->nb_societes = $count_societes;
                }

                return view('gouvernorats.societes_os', compact('secteur','gouvernorats'));
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
            'nom_societe' => 'required|max:255|unique:societes,nom_societe,NULL,id,delegation_id,'.$request->delegation_id.',secteur_id,'.$request->secteur_id,
            'nom_marque' => 'max:255',
            'type_societe_id' => 'required|numeric',
            'date_cration_societe' => 'date|date_format:d/m/Y',
            'delegation_id' => 'required|numeric',
            'secteur_id' => 'required|numeric',
            'accord_de_fondation' => 'required|numeric',
            'convention_cadre_commun' => 'required|numeric',
            'convention_id' => 'required|numeric',
            'nombre_travailleurs_cdi' => 'required|numeric',
            'nombre_travailleurs_cdd' => 'required|numeric'
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
        if($request->date_cration_societe == '') {
            $request->date_cration_societe = null;
        } else {
            $date_fr = explode('/', $request->date_cration_societe );
            $request->date_cration_societe = $date_fr[2].'-'.$date_fr[1].'-'.$date_fr[0];
        }

        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                $delegationControled = Delegation::find($request->delegation_id);
                if( $delegationControled->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;

            case "observateur_secteur":
                $secteurControled = Secteur::find($request->secteur_id);
                if( $secteurControled->id != Auth::user()->roleuser->secteur_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }

                break;
        }

        // save delegation
        $societe_adedd = new Societe;
        $societe_adedd->nom_societe = $request->nom_societe;
        if( strlen($request->nom_marque) == 0 ) {
            $request->nom_marque = $request->nom_societe;
        }
        $societe_adedd->nom_marque = $request->nom_marque;
        $societe_adedd->type_societe_id = $request->type_societe_id;
        $societe_adedd->date_cration_societe = $request->date_cration_societe;
        $societe_adedd->delegation_id = $request->delegation_id;
        $societe_adedd->secteur_id = $request->secteur_id;

        $societe_adedd->accord_de_fondation = $request->accord_de_fondation;
        $societe_adedd->convention_cadre_commun = $request->convention_cadre_commun;
        $societe_adedd->convention_id = $request->convention_id;
        $societe_adedd->nombre_travailleurs_cdi = $request->nombre_travailleurs_cdi;
        $societe_adedd->nombre_travailleurs_cdd = $request->nombre_travailleurs_cdd;

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
        echo $id;
    }

    public function showDossiers($id)
    {
        //
        $societe = Societe::find($id);
        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                if( $societe->delegation->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    return redirect('notacces');
                }
                break;

            case "observateur_secteur":
                if( $societe->secteur_id != Auth::user()->roleuser->secteur_id) {
                    return redirect('notacces');
                }

                break;
        }

        return view('societes.dossiers', compact('societe'));
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

    public function showDelegationRegional($id_secteur)
    {
        $secteur = Secteur::find($id_secteur);

        if(!$secteur) {
            return redirect('error');
        }

        $gouvernorat = Gouvernorat::find(Auth::user()->roleuser->gouvernorat_id);

        $nb_societes = 0;

        foreach ($gouvernorat->delegations as $delegation) {
            $delegation->setSecteur($secteur->id);
            $nb_societes += $delegation->societesViaSecteur->count();
        }
        $gouvernorat->nb_societes = $nb_societes;

        return view('delegations.societes', compact('secteur','gouvernorat'));
    }

    public function showDelegationSectorial($id_gouvernorat)
    {
        $gouvernorat = Gouvernorat::find($id_gouvernorat);

        if(!$gouvernorat) {
            return redirect('error');
        }

        $secteur = Secteur::find(Auth::user()->roleuser->secteur_id);

        $nb_societes = 0;
        foreach ($gouvernorat->delegations as $delegation) {
            $delegation->setSecteur($secteur->id);
            $nb_societes += $delegation->societesViaSecteur->count();
        }
        $gouvernorat->nb_societes = $nb_societes;

        return view('delegations.societes', compact('secteur','gouvernorat'));
    }

    public function showDelegationByAdmin($id_secteur, $id_gouvernorat)
    {
        $secteur = Secteur::find($id_secteur);

        $gouvernorat = Gouvernorat::find($id_gouvernorat);

        if(!$gouvernorat || !$secteur) {
            return redirect('error');
        }

        $nb_societes = 0;
        foreach ($gouvernorat->delegations as $delegation) {
            $delegation->setSecteur($secteur->id);
            $nb_societes += $delegation->societesViaSecteur->count();
        }
        $gouvernorat->nb_societes = $nb_societes;

        return view('delegations.societes', compact('secteur','gouvernorat'));
    }

    public function showSocietesByObservateurRegional($id_secteur, $id_delegation)
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

    public function showSocietesByObservateurSectorial($id_delegation)
    {
        $delegation = Delegation::find($id_delegation);

        if(!$delegation) {
            return redirect('error');
        }

        $secteur = Secteur::find(Auth::user()->roleuser->secteur_id);

        $types_societes = TypeSociete::orderBy('id', 'asc')->get();

        //set croisment
        $delegation->setSecteur($secteur->id);

        return view('societes.index', compact('secteur','delegation','types_societes'));
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
        $societeUpdated = Societe::find($id);

        $validator = Validator::make($request->all(), [
            'nom_societe' => 'required|max:255|unique:societes,nom_societe,'.$societeUpdated->id.',id,delegation_id,'.$societeUpdated->delegation_id.',secteur_id,'.$societeUpdated->secteur_id,
            'nom_marque' => 'max:255',
            'type_societe_id' => 'required|numeric',
            'date_cration_societe' => 'date|date_format:d/m/Y'
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
        if($request->date_cration_societe == '') {
            $request->date_cration_societe = null;
        } else {
            $date_fr = explode('/', $request->date_cration_societe );
            $request->date_cration_societe = $date_fr[2].'-'.$date_fr[1].'-'.$date_fr[0];
        }

        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                $delegationControled = Delegation::find($societeUpdated->delegation_id);
                if( $delegationControled->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;

            case "observateur_secteur":
                $secteurControled = Secteur::find($societeUpdated->secteur_id);
                if( $secteurControled->id != Auth::user()->roleuser->secteur_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;
        }

        // save secteur
        $societeUpdated->nom_societe = $request->nom_societe;
        $societeUpdated->nom_marque = $request->nom_marque;
        $societeUpdated->type_societe_id = $request->type_societe_id;
        $societeUpdated->date_cration_societe = $request->date_cration_societe;

        $societeUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('societe.message_update_succes_societe'),
        );

        return response()->json($response);
    }

    public function updateConvention(Request $request, $id)
    {
        $societeUpdated = Societe::find($id);

        $validator = Validator::make($request->all(), [
            'accord_de_fondation' => 'required|numeric',
            'convention_cadre_commun' => 'required|numeric',
            'convention_id' => 'required|numeric',
            'nombre_travailleurs_cdi' => 'required|numeric',
            'nombre_travailleurs_cdd' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $response = array(
                'status' => 'pb_validate',
                'msg' => trans('main.problem_sauve'),
                'msg_text' => $validator->errors()->all(),
            );

            return $response ;
        }

        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                $delegationControled = Delegation::find($societeUpdated->delegation_id);
                if( $delegationControled->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;

            case "observateur_secteur":
                $secteurControled = Secteur::find($societeUpdated->secteur_id);
                if( $secteurControled->id != Auth::user()->roleuser->secteur_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;
        }

        // save secteur
        $societeUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('societe.message_update_succes_societe'),
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

        $societeDeleted = Societe::find($id);

        switch (Auth::user()->getRole()) {
            case "observateur":
                $response = array(
                    'status' => 'notacces',
                    'msg' => trans('main.not_acces'),
                );
                return response()->json($response);
                break;

            case "observateur_regional":
                $delegationControled = Delegation::find($societeDeleted->delegation_id);
                if( $delegationControled->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;

            case "observateur_secteur":
                $secteurControled = Secteur::find($societeDeleted->secteur_id);
                if( $secteurControled->id != Auth::user()->roleuser->secteur_id) {
                    $response = array(
                        'status' => 'notacces',
                        'msg' => trans('main.not_acces'),
                    );
                    return response()->json($response);
                }
                break;
        }

        if($societeDeleted->dossiers->count() > 0) {
            $response = array(
                'status' => 'pb_database',
                'msg' => trans('main.problem_delet'),
                'msg_text' => trans('societe.indication_1_problem_delet'),
            );
        } else {
            $societeDeleted->delete();

            $response = array(
                'status' => 'success',
                'msg' => trans('societe.message_delete_succes_societe'),
            );
        }



        return response()->json($response);
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

        foreach ($societes as $societe) {
            $societe->nb_dossiers = $societe->dossiers->count();
            $societe->url_show_dossiers = route('societe.show.dossiers', $societe->id);

            $date_fr = explode('-', $societe->date_cration_societe );
            $societe->date_cration_societe = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];

        }

        switch (Auth::user()->getRole()) {
            case "administrator":
                $url_management_societes = route('societes.display.admin', ['id_secteur' => $secteur->id, 'id_delegation' => $delegation->id] );
                break;

            case "observateur_regional":
            case "observateur":
                $url_management_societes = route('societes_regional.display', ['id_secteur' => $secteur->id, 'id_delegation' => $delegation->id] );
                break;

            case "observateur_secteur":
                $url_management_societes = route('societes_sectorial.display', ['id_delegation' => $delegation->id] );
                break;
        }

        $reponse = [
            'status' => 'success',
            'elements' => $societes,
            'url_management' => $url_management_societes
        ];

        return response()->json($reponse);
    }
}

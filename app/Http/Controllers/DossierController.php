<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use Auth;

use App\Secteur;
use App\Gouvernorat;
use App\Societe;
use App\Dossier;
use App\Role_user;
use App\TypeViolation;
use App\StructureSyndicale;


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
                return view('dossiers.add.observater_r', compact('secteures','gouvernorat'));
                break;

            case "observateur_secteur":
                $secteur = Secteur::find(Auth::user()->roleuser->secteur_id);
                $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'asc')->get();
                return view('dossiers.add.observater_s', compact('secteur','gouvernorats'));
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

        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                if( $dossier->societe->delegation->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    return redirect('notacces');
                }
                break;

            case "observateur_secteur":
                if( $dossier->societe->secteur_id != Auth::user()->roleuser->secteur_id) {
                    return redirect('notacces');
                }

                break;
        }

        $gouvernorat_id = $dossier->societe->delegation->gouvernorat_id;
        $secteur_id = $dossier->societe->secteur_id;

        if($dossier->societe->date_cration_societe != null && $dossier->societe->date_cration_societe != '') {
            $date_fr = explode('-', $dossier->societe->date_cration_societe );
            $dossier->societe->date_cration_societe = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
        }

        $nb_abus_gravite_danger = 0;
        $nb_abus_gravite_warning = 0;

        $nb_accrochages_moves = 0;
        $nb_accrochages_plaintes = 0;
        $nb_accrochages_medias = 0;

        foreach ($dossier->abus_display as $abu) {

            if($abu->date_violation != null && $abu->date_violation != '') {
                $date_fr = explode('-', $abu->date_violation );
                $abu->date_violation = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }

            if( $abu->violation->gravite->id == 2 ) {
                $nb_abus_gravite_danger++;
            }

            if( $abu->violation->gravite->id == 1 ) {
                $nb_abus_gravite_warning++;
            }

            $nb_accrochages_moves += $abu->accrochages_moves->count();
            $nb_accrochages_plaintes += $abu->accrochages_plaintes->count();
            $nb_accrochages_medias += $abu->accrochages_medias->count();

        }
        $dossier->nb_abus_gravite_danger = $nb_abus_gravite_danger;
        $dossier->nb_abus_gravite_warning = $nb_abus_gravite_warning;

        $dossier->nb_accrochages_moves = $nb_accrochages_moves;
        $dossier->nb_accrochages_plaintes = $nb_accrochages_plaintes;
        $dossier->nb_accrochages_medias = $nb_accrochages_medias;

        $users_concernes = Role_user::where('gouvernorat_id', $gouvernorat_id)
            ->orWhere('secteur_id', $secteur_id)
            ->orWhere(function ($query) {
                    $query->where('gouvernorat_id', 0)->where('secteur_id', 0);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('dossiers.show', compact('dossier','users_concernes'));
    }

    public function gestionAbus($id)
    {
        $dossier = Dossier::find($id);

        switch (Auth::user()->getRole()) {
            case "observateur_regional":
            case "observateur":
                if( $dossier->societe->delegation->gouvernorat_id != Auth::user()->roleuser->gouvernorat_id) {
                    return redirect('notacces');
                }
                break;

            case "observateur_secteur":
                if( $dossier->societe->secteur_id != Auth::user()->roleuser->secteur_id) {
                    return redirect('notacces');
                }

                break;
        }

        $types_violations_1 = TypeViolation::find(1);
        $types_violations_2 = TypeViolation::find(2);

        $structures_syndicales = StructureSyndicale::orderBy('type_structure_syndicale', 'asc')->get();

        return view('dossiers.gestion', compact('dossier', 'types_violations_1', 'types_violations_2', 'structures_syndicales'));
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
        $dossierRemoveed = Dossier::find($id);

        if( Auth::user()->isAdmin() ||  $dossierRemoveed->created_by == Auth::user()->id) {

            // removes violation + mouvement  + les notes qui sont liees

            $id_dossier_removed = sprintf("%05d", $dossierRemoveed->id);

            $dossierRemoveed->delete();

            $response = array(
                'status' => 'success',
                'msg' => trans('dossier.message_delete_succes_dossier') . ' ' . $id_dossier_removed . ' ' . trans('dossier.from_systeme'),
            );
        } else {
            $response = array(
                'status' => 'notacces',
                'msg' => trans('main.not_acces'),
                'msg_text' => '',
            );
        }

        return response()->json($response);

    }

    public function mesDossiers() {

        $title_page = trans('dossier.myfiles');
        $desription_page = trans('dossier.description_myfiles');

        $dossiers = Dossier::orderBy('id', 'desc')->get();
        //Auth::user()
        return view('dossiers.filtres', compact('title_page', 'desription_page','dossiers'));
    }

    public function newDossiers() {

        $title_page = trans('dossier.files_non_lus');
        $desription_page = trans('dossier.description_files_non_lus');

        $dossiers = Dossier::orderBy('id', 'desc')->get();
        //Auth::user()
        return view('dossiers.filtres', compact('title_page', 'desription_page','dossiers'));
    }

    public function importantDossiers() {

        $title_page = trans('dossier.files_important');
        $desription_page = trans('dossier.description_files_important');

        $dossiers = Dossier::orderBy('id', 'desc')->get();
        //Auth::user()
        return view('dossiers.filtres', compact('title_page', 'desription_page','dossiers'));
    }
}

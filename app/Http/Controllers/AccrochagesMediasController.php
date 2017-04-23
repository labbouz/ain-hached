<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;

use App\Abus;
use App\Media;
use App\AccrochageMedia;

class AccrochagesMediasController extends Controller
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

    public function indexMedias($id)
    {

        $abus = Abus::find($id);

        $medias = Media::orderBy('id', 'asc')->get();

        return view('accrochages_medias.index', compact('abus', 'medias'));
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
            'abu_id' => 'required|numeric',
            'media_id' => 'required|numeric',
            'date_accrochage' => 'date_format:d/m/Y',
            'description_accrochage' => 'string'
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
        if($request->date_accrochage == '') {
            $request->date_accrochage = null;
        } else {
            $date_fr = explode('/', $request->date_accrochage );
            $request->date_accrochage = $date_fr[2].'-'.$date_fr[1].'-'.$date_fr[0];
        }

        // save secteur
        $accrochage_media_adedd = new AccrochageMedia;
        $accrochage_media_adedd->abu_id = $request->abu_id;
        $accrochage_media_adedd->media_id = $request->media_id;
        $accrochage_media_adedd->date_accrochage = $request->date_accrochage;
        $accrochage_media_adedd->description_accrochage = $request->description_accrochage;
        $accrochage_media_adedd->document = '';
        $accrochage_media_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_save_succes_accrochage'),
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
        $AccrochageUpdated = AccrochageMedia::find($id);

        $validator = Validator::make($request->all(), [
            'move_id' => 'required|numeric',
            'date_accrochage' => 'date_format:d/m/Y',
            'description_accrochage' => 'string'
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
        if($request->date_accrochage == '') {
            $request->date_accrochage = null;
        } else {
            $date_fr = explode('/', $request->date_accrochage );
            $request->date_accrochage = $date_fr[2].'-'.$date_fr[1].'-'.$date_fr[0];
        }

        $AccrochageUpdated->move_id = $request->move_id;
        $AccrochageUpdated->date_accrochage = $request->date_accrochage;
        $AccrochageUpdated->description_accrochage = $request->description_accrochage;
        // save secteur
        $AccrochageUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_update_succes_accrochage'),
            'nom_accrochage' => $AccrochageUpdated->media->categorie_media->nom_categorie_media .  '  ' . $AccrochageUpdated->media->nom_media,
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
        AccrochageMedia::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_delete_succes_accrochage'),
        );

        return response()->json($response);
    }

    public function getElementsJSON($abus_id)
    {

        $abus = Abus::find($abus_id);

        $accrochages_medias = $abus->accrochages_medias;

        foreach ($accrochages_medias as $accrochage_media) {
            $accrochage_media->nom_accrochage = $accrochage_media->media->categorie_media->nom_categorie_media .  '  ' . $accrochage_media->media->nom_media;

            if($accrochage_media->date_accrochage != null && $accrochage_media->date_accrochage != '') {
                $date_fr = explode('-', $accrochage_media->date_accrochage );
                $accrochage_media->date_accrochage = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }
        }


        $reponse = [
            'status' => 'success',
            'elements' => $accrochages_medias,
        ];

        return response()->json($reponse);
    }
}

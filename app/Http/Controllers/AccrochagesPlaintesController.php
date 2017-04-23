<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;

use App\Abus;
use App\Plainte;
use App\AccrochagePlainte;

class AccrochagesPlaintesController extends Controller
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

    public function indexPlaintes($id)
    {

        $abus = Abus::find($id);

        $plaintes = Plainte::orderBy('id', 'asc')->get();

        return view('accrochages_plaintes.index', compact('abus', 'plaintes'));
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
            'plainte_id' => 'required|numeric',
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
        $accrochage_plainte_adedd = new AccrochagePlainte;
        $accrochage_plainte_adedd->abu_id = $request->abu_id;
        $accrochage_plainte_adedd->plainte_id = $request->plainte_id;
        $accrochage_plainte_adedd->date_accrochage = $request->date_accrochage;
        $accrochage_plainte_adedd->description_accrochage = $request->description_accrochage;
        $accrochage_plainte_adedd->document = '';
        $accrochage_plainte_adedd->save();
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
        $AccrochageUpdated = AccrochagePlainte::find($id);

        $validator = Validator::make($request->all(), [
            'plainte_id' => 'required|numeric',
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

        $AccrochageUpdated->plainte_id = $request->plainte_id;
        $AccrochageUpdated->date_accrochage = $request->date_accrochage;
        $AccrochageUpdated->description_accrochage = $request->description_accrochage;
        // save secteur
        $AccrochageUpdated->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_update_succes_accrochage'),
            'nom_accrochage' => $AccrochageUpdated->plainte->nom_plainte,
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
        AccrochagePlainte::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_delete_succes_accrochage'),
        );

        return response()->json($response);
    }

    public function getElementsJSON($abus_id)
    {

        $abus = Abus::find($abus_id);

        $accrochages_plaintes = $abus->accrochages_plaintes;

        foreach ($accrochages_plaintes as $accrochage_plainte) {
            $accrochage_plainte->nom_accrochage = $accrochage_plainte->plainte->nom_plainte;

            if($accrochage_plainte->date_accrochage != null && $accrochage_plainte->date_accrochage != '') {
                $date_fr = explode('-', $accrochage_plainte->date_accrochage );
                $accrochage_plainte->date_accrochage = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }
        }


        $reponse = [
            'status' => 'success',
            'elements' => $accrochages_plaintes,
        ];

        return response()->json($reponse);
    }
}

<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;

use App\Abus;
use App\Move;
use App\AccrochageMove;


class AccrochagesMovesController extends Controller
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

    public function indexMoves($id)
    {

        $abus = Abus::find($id);

        $moves = Move::orderBy('id', 'asc')->get();

        return view('accrochages_moves.index', compact('abus', 'moves'));
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

        // save secteur
        $accrochage_move_adedd = new AccrochageMove;
        $accrochage_move_adedd->abu_id = $request->abu_id;
        $accrochage_move_adedd->move_id = $request->move_id;
        $accrochage_move_adedd->date_accrochage = $request->date_accrochage;
        $accrochage_move_adedd->description_accrochage = $request->description_accrochage;
        $accrochage_move_adedd->document = '';
        $accrochage_move_adedd->save();
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
        $AccrochageUpdated = AccrochageMove::find($id);

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
            'nom_accrochage' => $AccrochageUpdated->move->nom_move,
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
        AccrochageMove::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('abus.message_delete_succes_accrochage'),
        );

        return response()->json($response);
    }

    public function getElementsJSON($abus_id)
    {

        $abus = Abus::find($abus_id);

        $accrochages_moves = $abus->accrochages_moves;

        foreach ($accrochages_moves as $accrochage_move) {
            $accrochage_move->nom_accrochage = $accrochage_move->move->nom_move;

            if($accrochage_move->date_accrochage != null && $accrochage_move->date_accrochage != '') {
                $date_fr = explode('-', $accrochage_move->date_accrochage );
                $accrochage_move->date_accrochage = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
            }
        }


        $reponse = [
            'status' => 'success',
            'elements' => $accrochages_moves,
        ];

        return response()->json($reponse);
    }
}

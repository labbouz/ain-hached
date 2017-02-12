<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Move;

class MoveController extends Controller
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
        return view('moves.index');
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
            'nom_move' => 'required|unique:moves,nom_move|max:255',
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
        $moveadedd = new Move;
        $moveadedd->nom_move = $request->nom_move;
        $moveadedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('move.message_save_succes_move'),
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
        $moveUpdated = Move::find($id);

        $validator = Validator::make($request->all(), [
            'nom_move' => 'required|unique:moves,nom_move,'.$moveUpdated->id.'|max:255',
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
        $moveUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('move.message_update_succes_move'),
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
        Move::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('move.message_delete_succes_move'),
        );

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        //$secteures = Secteur::all();
        $move = Move::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $move,
        ];

        return response()->json($reponse);
    }
}

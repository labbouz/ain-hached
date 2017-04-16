<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Plainte;


class PlainteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('plaintes.index');
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
            'nom_plainte' => 'required|unique:plaintes,nom_plainte|max:255'
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
        $plainte_adedd = new Plainte;
        $plainte_adedd->nom_plainte = $request->nom_plainte;
        $plainte_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('plainte.message_save_succes_plainte'),
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
        $plainteUpdated = Plainte::find($id);

        $validator = Validator::make($request->all(), [
            'nom_plainte' => 'required|unique:plaintes,nom_plainte,'.$plainteUpdated->id.'|max:255'
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
        $plainteUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('plainte.message_update_succes_plainte'),
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
        Plainte::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('plainte.message_delete_succes_plainte'),
        );

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        $plainte = Plainte::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $plainte,
        ];

        return response()->json($reponse);
    }
}

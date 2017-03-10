<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\TypeSociete;

class TypeSocieteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('types_societes.index');
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
            'nom_type_societe' => 'required|unique:types_societes,nom_type_societe|max:255'
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
        $typeSocieteadedd = new TypeSociete;
        $typeSocieteadedd->nom_type_societe = $request->nom_type_societe;
        $typeSocieteadedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('societe.message_save_succes_type_societe'),
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
        $typeSocieteUpdated = TypeSociete::find($id);

        $validator = Validator::make($request->all(), [
            'nom_type_societe' => 'required|unique:types_societes,nom_type_societe,'.$typeSocieteUpdated->id.'|max:255'
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
        $typeSocieteUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('societe.message_update_succes_type_societe'),
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
        TypeSociete::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('societe.message_delete_succes_type_societe'),
        );

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        //$secteures = Secteur::all();
        $types_societes = TypeSociete::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $types_societes,
        ];

        return response()->json($reponse);
    }
}

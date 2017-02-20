<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\StructureSyndicale;

class StructureSyndicaleController extends Controller
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
        return view('structures_syndicales.index');
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
            'type_structure_syndicale' => 'required|unique:structures_syndicales,type_structure_syndicale|max:255',
            'description_type' => 'string'
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
        $structureSyndicaleadedd = new StructureSyndicale;
        $structureSyndicaleadedd->type_structure_syndicale = $request->type_structure_syndicale;
        $structureSyndicaleadedd->description_type = $request->description_type;
        $structureSyndicaleadedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('syndicale.message_save_succes_structure_syndicale'),
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
        $structureSyndicaleUpdated = StructureSyndicale::find($id);

        $validator = Validator::make($request->all(), [
            'type_structure_syndicale' => 'required|unique:structures_syndicales,type_structure_syndicale,'.$structureSyndicaleUpdated->id.'|max:255',
            'description_type' => 'string'
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
        $structureSyndicaleUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('syndicale.message_update_succes_structure_syndicale'),
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
        StructureSyndicale::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('syndicale.message_delete_succes_structure_syndicale'),
        );

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        //$secteures = Secteur::all();
        $structures_syndicales = StructureSyndicale::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $structures_syndicales,
        ];

        return response()->json($reponse);
    }
}

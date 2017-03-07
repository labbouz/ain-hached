<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Violation;
use App\TypeViolation;
use App\Gravite;

class ViolationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types_violations = TypeViolation::orderBy('nom_type_violation', 'asc')->get();
        $gravites = Gravite::orderBy('nom_gravite', 'asc')->get();

        return view('violations.index', compact('types_violations','gravites'));
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
            'nom_violation' => 'required|unique:violations,nom_violation|max:255',
            'description_violation' => 'string',
            'type_violation_id' => 'required|numeric',
            'gravite_id' => 'required|numeric'
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
        $violation_adedd = new Violation;
        $violation_adedd->nom_violation = $request->nom_violation;
        $violation_adedd->description_violation = $request->description_violation;
        $violation_adedd->type_violation_id = $request->type_violation_id;
        $violation_adedd->gravite_id = $request->gravite_id;
        $violation_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('violations.message_save_succes_violation'),
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
        $violationUpdated = Violation::find($id);

        $validator = Validator::make($request->all(), [
            'nom_violation' => 'required|unique:violations,nom_violation,'.$violationUpdated->id.'|max:255',
            'description_violation' => 'string',
            'type_violation_id' => 'required|numeric',
            'gravite_id' => 'required|numeric'
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
        $violationUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('violations.message_update_succes_violation'),
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
        Violation::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('violations.message_delete_succes_violation'),
        );

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        $violation = Violation::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $violation,
        ];

        return response()->json($reponse);
    }

}

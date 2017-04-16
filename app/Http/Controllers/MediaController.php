<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Media;
use App\CategorieMedia;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_medias = CategorieMedia::orderBy('id', 'asc')->get();

        return view('medias.index', compact('categories_medias'));
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
            'nom_media' => 'required|max:255|unique:medias,nom_media,NULL,id,categorie_media_id,'.$request->categorie_media_id,
            'categorie_media_id' => 'required|numeric'
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
        $media_adedd = new Media;
        $media_adedd->nom_media = $request->nom_media;
        $media_adedd->categorie_media_id = $request->categorie_media_id;
        $media_adedd->save();
        $response = array(
            'status' => 'success',
            'msg' => trans('media.message_save_succes_media'),
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
        $mediaUpdated = Media::find($id);

        $validator = Validator::make($request->all(), [
            'nom_media' => 'required|max:255|unique:medias,nom_media,'.$mediaUpdated->id.',id,categorie_media_id,'.$request->categorie_media_id,
            'categorie_media_id' => 'required|numeric'
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
        $mediaUpdated->fill( $request->all() )->save();

        $response = array(
            'status' => 'success',
            'msg' => trans('media.message_update_succes_media'),
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
        Media::find($id)->delete();

        $response = array(
            'status' => 'success',
            'msg' => trans('media.message_delete_succes_media'),
        );

        return response()->json($response);
    }

    public function getElementsJSON()
    {

        $medias = Media::orderBy('id', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $medias,
        ];

        return response()->json($reponse);
    }
}

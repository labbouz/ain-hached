<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gouvernorat;

class GouvernoratController extends Controller
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

    public function getElementsJSON()
    {

        $gouvernorats = Gouvernorat::orderBy('nom_gouvernorat', 'desc')->get();

        $reponse = [
            'status' => 'success',
            'elements' => $gouvernorats,
        ];

        return response()->json($reponse);
    }
}

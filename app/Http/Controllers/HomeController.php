<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function setting()
    {
        return view('setting');
    }

    public function dashboardDossiers()
    {
        return view('dashboard.dossiers');
    }

    public function notacces()
    {
        return view('notacces');
    }

    public function error()
    {
        return view('errors');
    }

}

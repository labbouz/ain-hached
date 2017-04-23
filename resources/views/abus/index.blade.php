@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/dossier.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container menu-partiel">
        <div class="row" dir="rtl">
            <div class="col-md-1 icon square">
                <a href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="@lang('main.dashboard')">
                    <i class="fa fa-tachometer" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ route('dossier.gestion', $abus->dossier->id ) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('abus.gestion_abus_number_file') {{ sprintf("%05d", $abus->dossier->id) }} @lang('abus.abus_from') {{ $abus->dossier->societe->nom_societe }}">
                    <i class="fa fa-fire" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ route('dossier.show', $abus->dossier->id ) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('dossier.detail_historique_dossier') {{ sprintf("%05d", $abus->dossier->id) }} @lang('abus.abus_from') {{ $abus->dossier->societe->nom_societe }}">
                    <i class="fa fa-folder-open" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ route('societe.show.dossiers', $abus->dossier->societe->id) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('societe.gestion_dossiers') {{ $abus->dossier->societe->nom_societe }}">
                    <i class="fa fa-archive" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ route('societes.show', $abus->dossier->societe->id) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('societe.gestion_dossiers') {{ $abus->dossier->societe->nom_societe }}">
                    <i class="fa fa-building" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ URL::previous() }}" data-toggle="tooltip" data-placement="right" title="@lang('main.retour_previous')">
                    <i class="fa fa-reply" aria-hidden="true" ></i>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6 detail_abus">
                <i class="fa fa-{{ $abus->violation->type_violation->class_color_type_violation }}"></i>
                <i class="fa fa-{{ $abus->violation->gravite->class_color_gravite }}"></i>
            </div>
            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                <h4 dir="rtl">@lang('abus.abu') {{ $abus->violation->gravite->nom_gravite }} {{ $abus->violation->type_violation->nom_type_violation }}</h4>
            </div>
        </div>

        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-fire fa-lg"></i></div>
                    <div class="titlr_box"><h2>{{ $abus->violation->nom_violation }}</h2></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')


    <div class="container">
        <div class="row row-rtl" dir="rtl">


        </div>
    </div>
@endsection

@section('url_ajax')

@endsection

@section('footer')
    <script src="{{ asset('js/show_abus.js') }}"></script>
@endsection
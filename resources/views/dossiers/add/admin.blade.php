@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/add_dossier.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('dashboard.dossiers') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('dossier.cpanel_dossier')"></i></a>
                        <h3 class="titles">
                            <span id="title_choizir_secteur">@lang('dossier.choizir_secteur')</span>
                            <span id="title_choizir_gouvernorat">@lang('dossier.choizir_gouvernorat')</span>
                            <span id="title_choizir_delegation">@lang('dossier.choizir_delegation')</span>
                            <span id="title_choizir_societe">@lang('dossier.choizir_societe')</span>
                        </h3>
                        <p class="text-muted text-danger">@lang('dossier.description_creation_dossier') <i class="fa fa-exclamation-circle" aria-hidden="true"></i></p>
                    </div>

                    <div class="loading_data">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements_secteur" class="row">
            @foreach ($secteures as $secteure)
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
                    <div class="container_element">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <a href="javascript:void(0)" class="display_objet set_secteur" dir="rtl" data-ajax="{{ $secteure->id }}" data-field-name="{{ $secteure->nom_secteur }}">{{ $secteure->nom_secteur }}</a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach

        </div>

        <div id="list_elements_gouveronrat" class="row">
            @foreach ($gouvernorats as $gouvernorat)
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 container-card">
                    <div class="container_element">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <a href="javascript:void(0)" class="display_objet set_gouvernorat" dir="rtl" data-ajax="{{ $gouvernorat->id }}" data-field-name="{{ $gouvernorat->nom_gouvernorat }}">{{ $gouvernorat->nom_gouvernorat }}</a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


         </div>


        @foreach ($gouvernorats as $gouvernorat)
            <div id="list_elements_delegations_{{ $gouvernorat->id }}" class="row">
                @foreach ($gouvernorat->delegations as $delegation)
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 container-card">
                        <div class="container_element">

                            <div class="edit_card card box">
                                <div class="label_elemen">
                                    <a href="javascript:void(0)" class="display_objet set_delegation" dir="rtl" data-ajax="{{ $delegation->id }}" data-field-name="{{ $delegation->nom_delegation }}">{{ $delegation->nom_delegation }}</a>
                                </div>
                            </div>


                        </div>
                    </div>

                @endforeach
            </div>
        @endforeach

    </div>

    <div class="container container-tools">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 container-action">
                <div class="container_element">
                    <a href="javascript:void(0)" class="box add">
                        <span class="fa fa-plus-circle"></span>
                        <span class="text">@lang('societe.add_societe')</span>
                    </a>
                </div>


            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-8 container-action container-action-search">
                <div class="container_element container_element_search">
                    <div class="box add">
                        <span class="fa fa-search"> <span class="titre_input">@lang('dossier.search_societes')</span></span>
                        <form class="form-inline search-societes-names">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <div class="container container-empty-element">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 container-action">
                <div class="container_element">
                    <div class="box">
                        <p>
                            @lang('dossier.not_exit') @lang('dossier.not_exit_secteur') <strong id="indicat_secteur"></strong>
                            @lang('dossier.not_exit_delegation') <strong id="indicat_delegation"></strong>
                            @lang('dossier.not_exit_gouvenorat') <strong id="indicat_gouvenorat"></strong>
                        </p>
                    </div>
                </div>


            </div>


        </div>
    </div>

    <div class="container">
        <div id="list_elements" class="row">
            <div class="bg_detail"></div>


        </div>
    </div>


@endsection

@section('url_ajax')
    <input id="index" type="hidden" value="{{ route('json.region.societes.get.url') }}">
    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="edit nom_marque" dir="rtl">{nom_marque}</span>
                        <span class="edit nom_societe" dir="rtl">{nom_societe}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="secteur_id" value="0">
    <input type="hidden" id="gouvernorat_id" value="0">
    <input type="hidden" id="delegation_id" value="0">
    <input type="hidden" id="societe_id" value="0">

@endsection

@section('footer')
    <script src="{{ asset('js/management_add_dossier.js') }}"></script>
@endsection
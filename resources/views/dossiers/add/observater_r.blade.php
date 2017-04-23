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
                        <p class="text-muted text-danger" dir="rtl"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> @lang('dossier.description_creation_dossier') </p>
                        <p class="text-muted message_indicateur" dir="rtl"> @lang('dossier.description_creation_dossier_2') </p>
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


    </div>

    <div class="container container-tools">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 container-action">
                <div class="container_element">
                    <a id="url_management_societes" href="javascript:void(0)" class="box add">
                        <span class="fa fa-building"></span>
                        <span class="text">@lang('dossier.management_societe') <strong class="indicat_secteur"></strong>
                            @lang('dossier.not_exit_delegation') <strong class="indicat_delegation"></strong>
                            @lang('dossier.not_exit_gouvenorat') <strong class="indicat_gouvenorat">{{ $gouvernorat->nom_gouvernorat }}</strong></span>
                    </a>
                </div>


            </div>


            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7 container-action container-action-search">
                <div class="container_element container_element_search">
                    <div class="box add">
                        <span class="fa fa-search"> <span class="titre_input">@lang('dossier.search_societes')</span></span>
                        <form class="form-inline search-societes-names" dir="rtl">
                            <div class="form-group form-search-societes">
                                <input type="text" class="form-control" id="input-search" placeholder="@lang('dossier.search_in') @lang('societe.nom_societe') @lang('dossier.and') @lang('societe.nom_marque') @lang('dossier.search_in_secteur_delegation')">
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <hr>
            </div>
        </div>
    </div>

    <div class="container container-empty-element">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 container-action">
                <div class="container_element">
                    <div class="box">
                        <p>
                            @lang('dossier.not_exit') @lang('dossier.not_exit_secteur') <strong class="indicat_secteur"></strong>
                            @lang('dossier.not_exit_delegation') <strong class="indicat_delegation"></strong>
                            @lang('dossier.not_exit_gouvenorat') <strong class="indicat_gouvenorat">{{ $gouvernorat->nom_gouvernorat }}</strong>
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
    <input id="store" type="hidden" value="{{ route('dossier.store') }}">
    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen label_elemen_societe add_dossier" data-ajax="{id}" data-field-name="{nom_societe}"
                         data-warning="@lang('dossier.are_you_sure')"
                         data-text-warning=""
                         data-confirm-buttontext="@lang('dossier.confirmButtonText')"
                         data-cancel-buttonText="@lang('main.cancelButtonText')"
                         data-cancelled="@lang('main.cancelled')" >
                        <span class="nom_marque" dir="rtl">{nom_marque}</span>
                        <span class="nom_societe" dir="rtl">{nom_societe}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="secteur_id" value="0">
    <input type="hidden" id="gouvernorat_id" value="{{ $gouvernorat->id }}">
    <input type="hidden" id="delegation_id" value="0">
    <input type="hidden" id="societe_id" value="0">

    <div id="message_asked" class="hide">
        <p dir="rtl">
            @lang('dossier.description_are_you_sure') <br>
            <strong id="societe_label_text"></strong> <br>
            @lang('dossier.description_are_you_sure_secteur')  <strong id="secteur_label_text"></strong>
            @lang('dossier.not_exit_delegation') <strong id="delegation_label_text"></strong>
            @lang('dossier.not_exit_gouvenorat') <strong id="gouvernorat_label_text">{{ $gouvernorat->nom_gouvernorat }}</strong> .
        </p>
    </div>

@endsection

@section('footer')
    <script src="{{ asset('js/management_add_dossier.js') }}"></script>
@endsection
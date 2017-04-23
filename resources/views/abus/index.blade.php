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
                <a href="{{ route('societes.show', $abus->dossier->societe->id) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('societe.histrory_societe_detaille') {{ $abus->dossier->societe->nom_societe }}">
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
            <div class="col-xs-12 col-sm12 col-md-3 col-lg-3 detail_abus">
                <i class="fa fa-{{ $abus->violation->type_violation->class_color_type_violation }}"></i>
                <i class="fa fa-{{ $abus->violation->gravite->class_color_gravite }}"></i>
                <i class="fa statut_reglement_{{ $abus->statut_reglement }}"></i>

            </div>
            <div class="col-xs-12 col-sm12 col-md-9 col-lg-9">
                <h4 dir="rtl" class="status_abus">@lang('abus.abu') {{ $abus->violation->gravite->nom_gravite }} {{ $abus->violation->type_violation->nom_type_violation }} @lang('abus.for_date') {{ $abus->date_violation }} @lang('abus.resultat_abus_'.$abus->statut_reglement) </h4>
            </div>
        </div>

        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-fire fa-lg"></i></div>
                    <div class="titlr_box"><h2 dir="rtl">{{ $abus->violation->nom_violation }}</h2></div>
                </div>
            </div>
        </div>

        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                <div class="box-info box-liste-abus info_p_box">
                    <div class="icon_big"><i class="fa fa-frown-o fa-lg"></i></div>
                    <div class="titlr_box"><h2 dir="rtl">@lang('abus.endommage')</h2></div>

                    <div class="row row-rtl">
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.structure_syndicale') : <strong>{{ $abus->endommage->structure_syndicale->type_structure_syndicale }}</strong></p>
                        </div>

                        @if($abus->violation->type_violation_id == 1)
                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.prenom') : <strong>{{ $abus->endommage->prenom }}</strong></p>
                            </div>

                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.nom') : <strong>{{ $abus->endommage->nom }}</strong></p>
                            </div>

                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.genre') : <strong>@lang('abus.'.$abus->endommage->genre)</strong></p>
                            </div>
                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.age') : <strong>@lang('abus.age_type_'.$abus->endommage->age)</strong></p>
                            </div>
                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.etat_civil') :
                                    @if($abus->endommage->etat_civile == 0)
                                        <strong class="notice">@lang('abus.not_determine')</strong>
                                     @else
                                        <strong>@lang('abus.etat_civil_'.$abus->endommage->etat_civile)</strong>
                                    @endif
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.nombre_enfants_parrainage') : <strong>{{ $abus->endommage->nb_enfant }}</strong></p>
                            </div>
                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.telephone') : <strong>{{ $abus->endommage->phone_number }}</strong></p>
                            </div>
                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.email') :
                                    @if($abus->endommage->email == null)
                                        <strong class="notice">@lang('abus.not_determine')</strong>
                                    @else
                                        <strong>{{ $abus->endommage->email }}</strong>
                                    @endif
                                </p>
                            </div>

                            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                                <p dir="rtl">@lang('abus.delimitation') :
                                    @if($abus->endommage->type_contrat == 0)
                                        <strong class="notice">@lang('abus.not_determine')</strong>
                                    @else
                                        <strong>@lang('abus.delimitation_'.$abus->endommage->type_contrat)</strong>
                                    @endif

                                    </p>
                            </div>
                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                <p dir="rtl">@lang('abus.la_responsabilite_seniority_syndicale') : <strong>@lang('abus.la_responsabilite_seniority_syndicale_type_'.$abus->endommage->anciennete)</strong></p>
                            </div>
                        @endif



                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm12 col-md-6 col-lg-6">
                <div class="box-info box-liste-abus info_p_box">
                    <div class="icon_big"><i class="fa fa-hand-paper-o fa-lg"></i></div>
                    <div class="titlr_box"><h2 dir="rtl">@lang('abus.agresseur')</h2></div>

                    <div class="row row-rtl">

                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.prenom') :
                                @if($abus->agresseur->prenom == null)
                                    <strong class="notice">@lang('abus.not_determine')</strong>
                                @else
                                    <strong>{{ $abus->agresseur->prenom }}</strong>
                                @endif
                             </p>
                        </div>

                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.nom') :
                                @if($abus->agresseur->nom == null)
                                    <strong class="notice">@lang('abus.not_determine')</strong>
                                @else
                                    <strong>{{ $abus->agresseur->nom }}</strong>
                                @endif
                            </p>
                        </div>

                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.nationalite') :
                                @if($abus->agresseur->nationalite == null)
                                    <strong class="notice">@lang('abus.not_determine')</strong>
                                @else
                                    <strong>{{ $abus->agresseur->nationalite }}</strong>
                                @endif
                            </p>
                        </div>

                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <h4 dir="rtl">@lang('abus.responsabilite_represente_par')</h4>
                        </div>
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.responsabilite_represente_par_type_1') : <strong>@lang('abus.responsabilite_represente_'.$abus->agresseur->responsabilite_1)</strong></p>
                        </div>
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.responsabilite_represente_par_type_2') : <strong>@lang('abus.responsabilite_represente_'.$abus->agresseur->responsabilite_2)</strong></p>
                        </div>
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p dir="rtl">@lang('abus.responsabilite_represente_par_type_3') : <strong>@lang('abus.responsabilite_represente_'.$abus->agresseur->responsabilite_3)</strong></p>
                        </div>





                    </div>

                </div>
            </div>
        </div>

        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-map-signs fa-lg"></i></div>
                    <div class="titlr_box"><h2 dir="rtl">@lang('abus.accrochages_moves') <a href="{{ route('abus.moves', ['abus' => $abus]) }}" data-toggle="tooltip" data-placement="top" title="@lang('abus.gestion_moves_abus') {{ $abus->accrochages_moves->count() }}" >({{ $abus->accrochages_moves->count() }})</a></h2></div>

                    @foreach ($abus->accrochages_moves as $accrochage)
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <hr>
                            <h4 dir="rtl">{{ $accrochage->move->nom_move }}

                                @if( $accrochage->date_accrochage != null)
                                    - <span class="date_accrochage">{{ $accrochage->date_accrochage }}</span>
                                @endif
                            </h4>
                            @if( $accrochage->description_accrochage != null)
                                <p dir="rtl">{{ $accrochage->description_accrochage }}</p>
                            @endif

                        </div>
                    @endforeach

                </div>
            </div>


        </div>

        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-gavel fa-lg"></i></div>
                    <div class="titlr_box"><h2 dir="rtl">@lang('abus.accrochages_plaintes') <a href="{{ route('abus.plaintes', ['abus' => $abus]) }}" data-toggle="tooltip" data-placement="top" title="@lang('abus.gestion_plaintes_abus') {{ $abus->accrochages_plaintes->count() }}" >({{ $abus->accrochages_plaintes->count() }})</a></h2></div>

                    @foreach ($abus->accrochages_plaintes as $accrochage)
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <hr>
                            <h4 dir="rtl">{{ $accrochage->plainte->nom_plainte }}

                                @if( $accrochage->date_accrochage != null)
                                    - <span class="date_accrochage">{{ $accrochage->date_accrochage }}</span>
                                @endif
                            </h4>
                            @if( $accrochage->description_accrochage != null)
                                <p dir="rtl">{{ $accrochage->description_accrochage }}</p>
                            @endif

                        </div>
                    @endforeach


                </div>
            </div>
        </div>





        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-bullhorn fa-lg"></i></div>
                    <div class="titlr_box"><h2 dir="rtl">@lang('abus.accrochages_medias') <a href="{{ route('abus.medias', ['abus' => $abus]) }}" data-toggle="tooltip" data-placement="top" title="@lang('abus.gestion_medias_abus') {{ $abus->accrochages_medias->count() }}" >({{ $abus->accrochages_medias->count() }})</a></h2></div>

                    @foreach ($abus->accrochages_medias as $accrochage)
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <hr>
                            <h4 dir="rtl">{{ $accrochage->media->categorie_media->nom_categorie_media }} {{ $accrochage->media->nom_media }}

                                @if( $accrochage->date_accrochage != null)
                                    - <span class="date_accrochage">{{ $accrochage->date_accrochage }}</span>
                                @endif
                            </h4>
                            @if( $accrochage->description_accrochage != null)
                                <p dir="rtl">{{ $accrochage->description_accrochage }}</p>
                            @endif

                        </div>
                    @endforeach

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
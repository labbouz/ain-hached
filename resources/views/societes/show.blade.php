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
                <a href="{{ route('societe.show.dossiers', $societe->id) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('societe.gestion_dossiers') {{ $societe->nom_societe }}">
                    <i class="fa fa-archive" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="" data-toggle="modal" data-target="#detailSocietes">
                    <i class="fa fa-info-circle" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ URL::previous() }}" data-toggle="tooltip" data-placement="right" title="@lang('main.retour_previous')">
                    <i class="fa fa-reply" aria-hidden="true" ></i>
                </a>
            </div>
        </div>
    </div>

    <div  dir="rtl" class="modal fade" id="detailSocietes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" dir="rtl">
                    <h4 class="modal-title" id="myModalLabel">@lang('dossier.info_societe_principale')</h4>
                </div>
                <div class="modal-body">
                    <p>@lang('societe.nom_societe') : <strong>{{ $societe->nom_societe }}</strong></p>
                    <p>@lang('societe.nom_marque') : <strong>{{ $societe->nom_marque }}</strong></p>
                    <p>@lang('societe.type_societe') : <strong>{{ $societe->type_societe->nom_type_societe }}</strong></p>

                    <p>@lang('societe.date_cration_societe') : <strong>
                            @if( $societe->date_cration_societe == null )
                                @lang('dossier.not_info')
                            @else
                                {{ $societe->date_cration_societe }}
                            @endif
                        </strong></p>
                    <hr>
                    <h4>@lang('dossier.conventions_societe')</h4>
                    <p><strong>@lang('societe.accord_de_fondation_'.$societe->accord_de_fondation)</strong></p>
                    <p><strong>@lang('societe.convention_cadre_commun_'.$societe->convention_cadre_commun)</strong></p>
                    <p>@lang('societe.convention') :
                        <strong>
                            @if( $societe->convention == null )
                                @lang('societe.pas_de_convontion')
                            @else
                                {{ $societe->convention->nom_convention }}
                            @endif
                        </strong></p>
                    <p>@lang('societe.nombre_travailleurs_cdi') : <strong>{{ $societe->nombre_travailleurs_cdi }}</strong></p>
                    <p>@lang('societe.nombre_travailleurs_no_cdi') : <strong>{{ $societe->nombre_travailleurs_cdd }}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('dossier.close_popup')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="container">
        <div class="row row-rtl">
            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-building fa-lg"></i></div>
                    <div class="titlr_box">
                        <h2 dir="rtl">{{ $societe->nom_societe }}</h2>
                    </div>
                    <br style="clear: both">
                    <p dir="rtl"  class="nom_secteur_delegation"><span>@lang('dossier.societe_secteur') <strong>{{ $societe->secteur->nom_secteur }}</strong> @lang('dossier.societe_pour_delegation') <strong>{{ $societe->delegation->nom_delegation }}</strong> @lang('dossier.societe_pour_gouvenorat') <strong>{{ $societe->delegation->gouvernorat->nom_gouvernorat }}</strong></span></p>
                </div>
            </div>
        </div>

        <div class="row row-rtl" dir="rtl">
            <div class="col-xs-12 col-sm12 col-md-8 col-lg-8">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><i class="fa fa-fire fa-lg"></i></div>
                    <div class="titlr_box"><h2>@lang('abus.abus_inserer_sur_ce_societe')</h2></div>
                </div>

                <br style="clear:both;">
                {{-- /************************* Parti listing Abus****************************/ --}}

                @foreach($societe->dossiers as $dossier)

                    @foreach($dossier->abus_display as $abus)
                    <div class="container-fluid block-show-dossier">
                        <div class="row">
                            <div class="col-xs-12 col-sm12 col-md-3 col-lg-3 detail_abus">
                                <i class="fa fa-{{ $abus->violation->type_violation->class_color_type_violation }}"></i>
                                <i class="fa fa-{{ $abus->violation->gravite->class_color_gravite }}"></i>
                                <i class="fa statut_reglement_{{ $abus->statut_reglement }}"></i>

                            </div>
                            <div class="col-xs-12 col-sm12 col-md-9 col-lg-9">
                                <h4 dir="rtl" class="status_abus">@lang('abus.abu') {{ $abus->violation->gravite->nom_gravite }} {{ $abus->violation->type_violation->nom_type_violation }} @lang('abus.for_date') <strong>{{ $abus->date_violation }}</strong> @lang('abus.resultat_abus_'.$abus->statut_reglement) </h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                <h4 dir="rtl" class="status_abus">@lang('abus.from_dossier_numer')  <strong> {{ sprintf("%05d", $abus->dossier_id) }}</strong></h4>
                            </div>
                        </div>

                        <div class="row row-rtl">
                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                <div class="box-info box-liste-abus">
                                    <div class="icon_big"><a href="{{ route('abus.show', ['abus' => $abus]) }}" data-toggle="tooltip" data-placement="top" title="@lang('abus.display_detail_abus')"><i class="fa fa-eye fa-lg"></i></a></div>
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
                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.prenom') : <strong>{{ $abus->endommage->prenom }}</strong></p>
                                            </div>

                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.nom') : <strong>{{ $abus->endommage->nom }}</strong></p>
                                            </div>

                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.genre') : <strong>@lang('abus.'.$abus->endommage->genre)</strong></p>
                                            </div>
                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.age') : <strong>@lang('abus.age_type_'.$abus->endommage->age)</strong></p>
                                            </div>
                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.etat_civil') :
                                                    @if($abus->endommage->etat_civile == 0)
                                                        <strong class="notice">@lang('abus.not_determine')</strong>
                                                    @else
                                                        <strong>@lang('abus.etat_civil_'.$abus->endommage->etat_civile)</strong>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.nombre_enfants_parrainage') : <strong>{{ $abus->endommage->nb_enfant }}</strong></p>
                                            </div>
                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.telephone') : <strong>{{ $abus->endommage->phone_number }}</strong></p>
                                            </div>
                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                                                <p dir="rtl">@lang('abus.email') :
                                                    @if($abus->endommage->email == null)
                                                        <strong class="notice">@lang('abus.not_determine')</strong>
                                                    @else
                                                        <strong>{{ $abus->endommage->email }}</strong>
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
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

                    <hr class="separator_abus">

                    @endforeach
                @endforeach
                {{-- /************************* Fin Parti listing Abus****************************/ --}}


            </div>

            <div class="col-xs-12 col-sm12 col-md-4 col-lg-4">
                <div class="box-info box-observateurs-dossier">
                    <div class="icon_big"><i class="fa fa-users fa-lg" aria-hidden="true"></i></div>
                    <div class="titlr_box"><h2>@lang('dossier.observateurs_concernees')</h2></div>
                    <div class="clearfix list-user-concernees">
                        <ul>
                            @foreach ($users_concernes as $user_concerne)
                                @if($user_concerne->user->active  == 1)
                                <li>
                                <span class="profile">
                                    @if($user_concerne->user->avatar  == null)
                                        <img src="{{ Request::root() }}/images/avatars/anonyme.jpg" class="img-circle img-responsive">
                                    @else
                                        <img src="{{ Request::root() }}/images/avatars/{{ $user_concerne->user->avatar }}" class="img-circle img-responsive">
                                    @endif

                                </span>
                                    <span class="info">
                                    <span class="name_user">{{ $user_concerne->user->name }}</span>
                                    <span class="role"> {{ $user_concerne->role->name }} </span>
                                </span>


                                    @if($user_concerne->user_id != Auth::user()->id)
                                        <a href="" class="fa fa-envelope icon_observateur icon_info_send" aria-hidden="true" data-toggle="modal" data-target="#SendMessageA_{{ $user_concerne->id }}" ></a>
                                    @endif
                                    <a href="" class="fa fa-info-circle icon_observateur icon_info_contact" aria-hidden="true" data-toggle="modal" data-target="#InfoObservateurFor_{{ $user_concerne->id }}"></a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                </div>

                @foreach ($users_concernes as $user_concerne)
                    @if($user_concerne->user->active  == 1)
                        @if($user_concerne->user_id != Auth::user()->id)
                            <div class="modal fade" id="SendMessageA_{{ $user_concerne->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" dir="rtl">
                                            <h4 class="modal-title" id="myModalLabel">@lang('dossier.send_observateur')</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>@lang('dossier.send_l_observateur'){{ $user_concerne->role->name }} : <strong>{{ $user_concerne->user->name }}</strong></p>

                                            <p>@lang('dossier.sujet_send') : <strong>@lang('dossier.sujet_societe') {{ $societe->nom_societe }}</strong></p>
                                            <hr>
                                            <div class="form_send">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="text_message">@lang('dossier.the_send')</label>
                                                        <textarea id="text_message" class="form-control" rows="3"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="doc_joint">@lang('dossier.piece_jointe')</label>
                                                        <input type="file" id="doc_joint">
                                                    </div>

                                                    <button type="button" class="btn btn-primary send_message">@lang('dossier.send')</button>
                                                </form>
                                                <p class="bg-success message_succes_send">@lang('dossier.succes_send_message').</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('dossier.close_popup')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="modal fade" id="InfoObservateurFor_{{ $user_concerne->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" dir="rtl">
                                        <h4 class="modal-title" id="myModalLabel">@lang('dossier.card_observateur')</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center">

                                            @if($user_concerne->user->avatar  == null)
                                                <img src="{{ Request::root() }}/images/avatars/anonyme.jpg" class="img-thumbnail img-user-profile">
                                            @else
                                                <img src="{{ Request::root() }}/images/avatars/{{ $user_concerne->user->avatar }}" class="img-thumbnail img-user-profile">
                                            @endif
                                        </p>
                                        <h4><strong>{{ $user_concerne->role->name }}</strong></h4>
                                        <hr />
                                        <p>@lang('users.prenom') : <strong>{{ $user_concerne->user->prnom }}</strong></p>
                                        <p>@lang('users.nom') : <strong>{{ $user_concerne->user->nom }}</strong></p>
                                        <p>@lang('users.email') : <strong>{{ $user_concerne->user->email }}</strong></p>
                                        <p>@lang('users.societe') : <strong>
                                                @if( $user_concerne->user->societe != null)
                                                    {{ $user_concerne->user->societe }}
                                                @else
                                                    @lang('dossier.not_info')
                                                @endif
                                            </strong></p>
                                        <p>@lang('users.structure_syndicale') : <strong>
                                                @if( $user_concerne->user->structure_syndicale == null )
                                                    @lang('dossier.not_info')
                                                @else
                                                    {{ $user_concerne->user->structure_syndicale->type_structure_syndicale }}
                                                @endif
                                            </strong></p>
                                        <p>@lang('users.telephone') : <strong>
                                                @if( $user_concerne->user->phone_number != null)
                                                    {{ $user_concerne->user->phone_number }}
                                                @else
                                                    @lang('dossier.not_info')
                                                @endif
                                            </strong></p>
                                        <p>@lang('users.email2') : <strong>
                                                @if( $user_concerne->user->email2 != null)
                                                    {{ $user_concerne->user->email2 }}
                                                @else
                                                    @lang('dossier.not_info')
                                                @endif
                                            </strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('dossier.close_popup')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach

            </div>

        </div>
    </div>
@endsection

@section('url_ajax')

@endsection

@section('footer')
    <script src="{{ asset('js/show_dossier.js') }}"></script>
@endsection
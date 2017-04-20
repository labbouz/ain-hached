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
                <a href="{{ route('dossier.gestion', $dossier->id ) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('dossier.management_abus')">
                    <i class="fa fa-fire" aria-hidden="true" ></i>
                </a>
            </div>
            <div class="col-md-1 icon square">
                <a href="{{ URL::previous() }}" data-toggle="tooltip" data-placement="right" title="@lang('main.retour_previous')">
                    <i class="fa fa-reply" aria-hidden="true" ></i>
                </a>
            </div>
        </div>
     </div>
@endsection

@section('content')
    <div class="container">
        <div class="row row-rtl" dir="rtl">
            <div class="col-xs-12 col-sm12 col-md-4 col-lg-4">
                <div class="box-info box-number-dossier">
                    <p>
                        <span class="icon_big"><i class="fa fa-folder-open fa-lg"></i></span>
                        <span class="number_dossier">{{ sprintf("%05d", $dossier->id) }}</span>
                    </p>
                    <h6>@lang('societe.cree_par')</h6>
                    <p>
                        <span class="profile">
                            @if($dossier->user->avatar  == null)
                                <img src="{{ Request::root() }}/images/avatars/anonyme.jpg" class="img-circle img-responsive">
                            @else
                                <img src="{{ Request::root() }}/images/avatars/{{ $dossier->user->avatar }}" class="img-circle img-responsive">
                            @endif

                        </span>
                        <span class="info">
                            <span class="name_user">{{ $dossier->user->name }}</span>
                            <span class="role"> {{ $dossier->user->roleuser->role->name }} </span>
                        </span>

                    </p>

                </div>

            </div>

            <div class="col-xs-12 col-sm12 col-md-4 col-lg-4">
                <div class="box-info box-resumer-dossier">
                    <div class="icon_big"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="titlr_box"><h2>@lang('dossier.resume_dossier')</h2></div>

                    <br style="clear:both;">
                    <div class="recap_dossier">
                        <div class="col-xs-4 gravite-danger">
                            <span class="chiffre">0</span> <i class="fa fa-thermometer-full" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('dossier.display_indicateur_gravite_danger')"></i>
                        </div>
                        <div class="col-xs-4 gravite-warning">
                            <span class="chiffre">0</span> <i class="fa fa-thermometer-half" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('dossier.display_indicateur_gravite_warning')"></i>
                        </div>
                        <div class="col-xs-4">
                            <span class="chiffre">0</span> <a class="fa fa-fire" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('dossier.display_indicateur_abus_gestion') {{ $dossier->abus->count() }}"></a>
                        </div>

                    </div>

                    <div class="recap_dossier">
                        <div class="col-xs-4">
                            <span class="chiffre">0</span> <i class="fa fa-map-signs" data-toggle="tooltip" data-placement="top" title="@lang('dossier.display_indicateur_confrontations_mouvements')"></i>
                        </div>
                        <div class="col-xs-4">
                            <span class="chiffre">0</span> <i class="fa fa-gavel" data-toggle="tooltip" data-placement="top" title="@lang('dossier.display_indicateur_confrontations_plaintes')"></i>
                        </div>
                        <div class="col-xs-4">
                            <span class="chiffre">0</span> <i class="fa fa-bullhorn" data-toggle="tooltip" data-placement="top" title="@lang('dossier.display_indicateur_confrontations_medias')"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm12 col-md-4 col-lg-4">
                <div class="box-info box-societe-dossier">
                    <div class="icon_big"><i class="fa fa-building fa-lg"></i></div>
                    <div class="info">
                        <span class="nom_marque">{{ $dossier->societe->nom_marque }}</span>
                        <span class="nom_societe">{{ $dossier->societe->nom_societe }}</span>
                    </div>

                    <div class="societe_local">
                        <span class="nom_secteur_delegation">@lang('dossier.societe_secteur') <strong>{{ $dossier->societe->secteur->nom_secteur }}</strong> @lang('dossier.societe_pour_delegation') <strong>{{ $dossier->societe->delegation->nom_delegation }}</strong> @lang('dossier.societe_pour_gouvenorat') <strong>{{ $dossier->societe->delegation->gouvernorat->nom_gouvernorat }}</strong></span>
                    </div>

                    <div class="recap_societe">
                        <div class="col-xs-4">
                            <a class="fa fa-info-circle" href="javascript:void(0)"></a>
                        </div>
                        <div class="col-xs-4">
                            <a class="fa fa-archive" href="{{ route('societe.show.dossiers', $dossier->societe->id ) }}" data-toggle="tooltip" data-placement="top" title="@lang('societe.display_dossiers_for_societees') {{ $dossier->societe->dossiers->count() }}"></a>
                        </div>
                        <div class="col-xs-4">
                            <a class="fa fa-eye" href="{{ route('societes.show', $dossier->societe->id ) }}"></a>
                        </div>
                    </div>


                </div>

            </div>

            <div class="col-xs-12 col-sm12 col-md-8 col-lg-8">
                <div class="box-info box-liste-abus">
                    <div class="icon_big"><a class="fa fa-fire fa-lg" href="javascript:void(0)"></a></div>
                    <div class="titlr_box"><h2>@lang('abus.abus_inserer_sur_ce_dossier')</h2></div>

                    <div class="row">
                        <div class="col-xs-12 col-sm12 col-md-12 col-lg-12">
                            <p class="alert"><strong>@lang('abus.aucun_abus')</strong> .... <strong><a href="javascript:void(0)">@lang('abus.gestion_abus')</a></strong></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm12 col-md-4 col-lg-4">
                <div class="box-info box-observateurs-dossier">
                    <div class="icon_big"><i class="fa fa-users fa-lg" aria-hidden="true"></i></div>
                    <div class="titlr_box"><h2>@lang('dossier.observateurs_concernees')</h2></div>
                    <div class="clearfix list-user-concernees">
                        <ul>
                            @foreach ($users_concernes as $user_concerne)
                                <li>
                                <span class="profile">
                                    @if($dossier->user->avatar  == null)
                                        <img src="{{ Request::root() }}/images/avatars/anonyme.jpg" class="img-circle img-responsive">
                                    @else
                                        <img src="{{ Request::root() }}/images/avatars/{{ $user_concerne->user->avatar }}" class="img-circle img-responsive">
                                    @endif

                                </span>
                                    <span class="info">
                                    <span class="name_user">{{ $user_concerne->user->name }}</span>
                                    <span class="role"> {{ $user_concerne->role->name }} </span>
                                </span>

                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('url_ajax')

@endsection

@section('footer')
    <script src="{{ asset('js/show_dossier.js') }}"></script>
@endsection
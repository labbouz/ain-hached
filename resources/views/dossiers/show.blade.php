@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/dossier.css') }}" rel="stylesheet">
@endsection

@section('page-title')
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
                <div class="box-info">
                    <h4>@lang('dossier.resume_dossier')</h4>
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
                el intihakat
            </div>

            <div class="col-xs-12 col-sm12 col-md-4 col-lg-4">
                <div class="box-info box-observateurs-dossier">
                    <div class="icon_big"><i class="fa fa-users fa-lg" aria-hidden="true"></i></div>
                    <div class="titlr_box"><h1>@lang('dossier.observateurs_concernees')</h1></div>
                    <ul>
                        <li>el ma3niyoun</li>
                        <li>el ma3niyoun</li>
                        <li>el ma3niyoun</li>
                        <li>el ma3niyoun</li>
                        <li>el ma3niyoun</li>
                        <li>el ma3niyoun</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')


@endsection

@section('url_ajax')

@endsection

@section('footer')
    <script src="{{ asset('js/show_dossier.js') }}"></script>
@endsection
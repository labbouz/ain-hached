@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/display_societes.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title" dir="rtl">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ URL::previous() }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.retour_previous')"></i></a>
                        <h3> @lang('societe.gestion_dossiers') : {{ $societe->nom_societe }}  </h3>
                        <p class="text-muted">@lang('societe.descr_gestion_dossiers')</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-action">
                    <a href="javascript:void(0)" class="box add add-dossier" data-ajax="{{ $societe->id }}" data-field-name="{{ $societe->nom_societe }}"
                       data-warning="@lang('dossier.are_you_sure')"
                       data-text-warning=""
                       data-confirm-buttontext="@lang('dossier.confirmButtonText')"
                       data-cancel-buttonText="@lang('main.cancelButtonText')"
                       data-cancelled="@lang('main.cancelled')">
                        <span class="fa fa-plus-circle"></span>
                        <span class="text">@lang('dossier.add_file') @lang('dossier.pour_societe')</span>
                    </a>
                </div>
        @foreach ($societe->dossiers as $dossier)
                <div id="id_{{ $dossier->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card" data-id="{{ $dossier->id }}">
                    <div class="container_element container_display_user">

                        <div class="edit_card card card-dossier box">
                            <div class="label_elemen label_elemen_file">
                                <a href="{{ route('dossier.show', $dossier->id ) }}" class="display_objet" dir="rtl">
                                    {{ sprintf("%05d", $dossier->id) }}
                                    <i class="fa fa-folder-open fa-lg"></i>
                                    <div class="creator">
                                        <span class="created_by">@lang('societe.cree_par')</span>
                                        <?php
                                        if($dossier->user->avatar  == null) {
                                            $user_image = 'images/avatars/anonyme.jpg';
                                        } else {
                                            $user_image = 'images/avatars/' . $dossier->user->avatar;
                                        }
                                        ?>
                                        <span class="info">
                                            {{ $dossier->user->name }}
                                            <br>
                                            <span class="role"> {{ $dossier->user->roleuser->role->name }}</span>
                                        </span>
                                        <span class="profile">
                                            <img src="{{ Request::root() }}/{{ $user_image }}" class="img-circle img-responsive">
                                        </span>
                                    </div>
                                </a>

                            </div>
                            <div class="toolbar_box toolbar_dossier"  dir="rtl">
                                <a href="javascript:void(0)" class="remove"
                                   data-warning="@lang('dossier.etes_vous_sure') {{ sprintf("%05d", $dossier->id) }} ؟"
                                   data-text-warning="@lang('dossier.suppression_defenitife_dossier')"
                                   data-confirm-buttontext="@lang('main.confirmButtonText')"
                                   data-cancel-buttonText="@lang('main.cancelButtonText')"
                                   data-cancelled="@lang('main.cancelled')"
                                ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('dossier.histrory_dossier_violations') 0">0 <i class="fa fa-fire" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('dossier.histrory_dossier')"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>

@endsection


@section('url_ajax')
    <input id="store" type="hidden" value="{{ route('dossier.store') }}">
    {{ csrf_field() }}

    <div id="message_asked" class="hide">
        <p dir="rtl">
            @lang('dossier.description_are_you_sure') <br>
            <strong id="societe_label_text">{{ $societe->nom_societe }}</strong> <br>
            @lang('dossier.description_are_you_sure_secteur')  <strong id="secteur_label_text">{{ $societe->secteur->nom_secteur }}</strong>
            @lang('dossier.not_exit_delegation') <strong id="delegation_label_text">{{ $societe->delegation->nom_delegation }}</strong>
            @lang('dossier.not_exit_gouvenorat') <strong id="gouvernorat_label_text">{{ $societe->delegation->gouvernorat->nom_gouvernorat }}</strong> .
        </p>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('js/display_societes.js') }}"></script>
@endsection
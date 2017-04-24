@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/display_dossier.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container menu-partiel">
        <div class="row" dir="rtl">

            @include('layouts.menu_dossiers')

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title" dir="rtl">
                    <div id="header_index">
                        <h3> {{ $title_page }} </h3>
                        <p class="text-muted" dir="rtl">{{ $desription_page }}</p>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
        @foreach ($dossiers as $dossier)
                <div id="id_{{ $dossier->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card" data-id="{{ $dossier->id }}">
                    <div class="container_element container_display_user">

                        <div class="edit_card card card-dossier box">
                            <div class="label_elemen label_elemen_file">
                                <a href="{{ route('dossier.show', $dossier->id ) }}" class="display_objet" dir="rtl">
                                    {{ sprintf("%05d", $dossier->id) }}
                                    <i class="fa fa-folder-open fa-lg"></i>

                                    <div class="info_societe">
                                        <div class="icon_societe">
                                            <i class="fa fa-building"></i>
                                        </div>
                                        <div class="info_nom_societe">
                                            <span class="nom_societe">{{ $dossier->societe->nom_societe }}</span>
                                            <span class="nom_marque">{{ $dossier->societe->nom_marque }}</span>
                                        </div>

                                    </div>
                                    <div class="creator">
                                        <span class="created_by">@lang('societe.cree_par')</span>
                                        <?php
                                        if($dossier->user->avatar  == null) {
                                            $user_image = 'images/avatars/anonyme.jpg';
                                        } else {
                                            $user_image = 'images/avatars/' . $dossier->user->avatar;
                                        }
                                        ?>
                                        <span class="profile">
                                            <img src="{{ Request::root() }}/{{ $user_image }}" class="img-circle img-responsive">
                                        </span>
                                        <span class="info">
                                            {{ $dossier->user->name }}
                                            <br>
                                            <span class="role"> {{ $dossier->user->roleuser->role->name }}</span>
                                        </span>

                                    </div>
                                </a>

                            </div>
                            <div class="toolbar_box toolbar_dossier"  dir="rtl">
                                <a href="{{ route('dossier.gestion', $dossier->id ) }}" data-toggle="tooltip" data-placement="top" title="@lang('dossier.histrory_dossier_violations') {{ $dossier->abus->count() }}">{{ $dossier->abus->count() }} <i class="fa fa-fire" aria-hidden="true"></i></a>
                                <a href="{{ route('dossier.show', $dossier->id ) }}" data-toggle="tooltip" data-placement="top" title="@lang('dossier.histrory_dossier')"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>
@endsection


@section('url_ajax')

@endsection

@section('footer')
    <script src="{{ asset('js/display_dossiers.js') }}"></script>

@endsection
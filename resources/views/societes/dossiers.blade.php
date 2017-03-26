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
                    <a href="javascript:void(0)" class="box add add-dossier">
                        <span class="fa fa-plus-circle"></span>
                        <span class="text">@lang('dossier.add_file') @lang('dossier.pour_societe')</span>
                    </a>
                </div>
        @foreach ($societe->dossiers as $dossier)
                <div id="id_{{ $dossier->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
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
                                   data-warning="@lang('main.etes_vous_sure')"
                                   data-text-warning="@lang('dossier.suppression_defenitife_dossier')"
                                   data-confirm-buttontext="@lang('main.confirmButtonText')"
                                   data-cancel-buttonText="@lang('main.cancelButtonText')"
                                   data-cancelled="@lang('main.cancelled')"
                                ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('dossier.histrory_dossier_violations') 0">0 <i class="fa fa-fire" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('dossier.histrory_dossier')"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                {{--
                                <a href="{{ route('societes_secteur.admin', ['id_secteur' => $secteure->id] ) }}"> {{ $secteure->societes->count() }} <i class="fa fa-building-o" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('societe.nb_societes')  : {{ $secteure->societes->count() }}" ></i></a>
                                --}}
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_societes.js') }}"></script>
@endsection
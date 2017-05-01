@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/contacts.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('home') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.dashboard')"></i></a>
                        <h3> @lang('main.contacts')  </h3>
                        <p class="text-muted">@lang('users.description_contacts')</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm12 col-xs-12">
                <div class="filtres filtres-role card box" dir="rtl">
                    <h4>@lang('users.search_role')</h4>
                    @foreach ($roles as $role)
                        <div class="has-rtl has_{{ $role->class_color }}">
                            <div class="checkbox">
                                <label>
                                    <input class="checkbox_role" type="checkbox" id="checkboxRole{{ $role->id }}" name="checkboxRole" value="{{ $role->slug }}" checked>
                                    {{ $role->name }}
                                </label>
                            </div>
                        </div>
                     @endforeach
                </div>

                <div class="filtres filtres-role card box" dir="rtl">
                    <h4>@lang('users.search_gouvernorats')</h4>
                    <select id="search_gouvernorat" class="form-control">
                        <option value="0">@lang('users.tous_gouvernorats')</option>
                    @foreach ($gouvernorats as $gouvernorat)
                        <option value="{{ $gouvernorat->id }}">@lang('users.gouvernorat_label') {{ $gouvernorat->nom_gouvernorat }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="filtres filtres-role card box" dir="rtl">
                    <h4>@lang('users.search_secteures')</h4>
                    <select id="search_secteur" class="form-control">
                        <option value="0">@lang('users.tous_secteurs')</option>
                        @foreach ($secteurs as $secteur)
                            <option value="{{ $secteur->id }}">@lang('users.secteur_label') {{ $secteur->nom_secteur }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="col-lg-9 col-md-8 col-sm12 col-xs-12">
                <div id="list_elements" class="row">
                    @foreach ($users as $user)
                        <div id="id_{{ $user->id }}" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 container-card" data-role="{{ $user->roleuser->role->slug }}" data-gouvernorat="{{ $user->roleuser->gouvernorat_id }}" data-secteur="{{ $user->roleuser->secteur_id }}" data-structure-syndicale="{{ $user->structure_syndicale_id }}">
                            <div class="container_element">

                                <div class="edit_card card box">
                                    <div class="label_elemen">
                                        <span class="status_active user_{{ $user->active }}">
                                            <i class="fa fa-check" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="@lang('users.user_active')"></i>
                                            <i class="fa fa-times" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="@lang('users.user_inactive')"></i>
                                        </span>
                                        <span class="profile change_avatar"><img data-origin="{{ Request::root() }}/{{ $user->avatar }}" src="{{ asset('images/avatars/anonyme.jpg') }}" alt="user-img" class="img-circle img-responsive"></span>
                                        <div class="edit info" dir="rtl">
                                            <span class="nom_observateur">{{ $user->prnom }} {{ $user->nom }}</span>
                                            <span class="info_role_observateur">{{ $user->roleuser->role->name }}
                                                <i class="info_bloc fa fa-info-circle {{ $user->roleuser->role->class_color }}" data-toggle="tooltip" data-placement="right" title="{{ $user->roleuser->role->description }}"></i></span>


                                            @if($user->isAdmin())
                                                <span class="indicateur_observateur">{{ $user->roleuser->role->description }}</span>
                                            @endif

                                            @if($user->isObservateurRegional() || $user->isObservateur())
                                                <span class="indicateur_observateur">@lang('users.pour_gouvernorat') {{ $user->roleuser->gouvernorat->nom_gouvernorat }}</span>
                                            @endif

                                            @if($user->isObservateurSectorial())
                                                <span class="indicateur_observateur">@lang('users.pour_secteur') {{ $user->roleuser->secteur->nom_secteur }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="toolbar_box"  dir="rtl">
                                        @if($user->id != Auth::user()->id && $user->active  == 1)
                                            <a href="" class="infosstem icon_observateur icon_info_send" aria-hidden="true" data-toggle="modal" data-target="#SendMessageA_{{ $user->id }}" ><i class="fa fa-envelope" aria-hidden="true" ></i></a>
                                        @endif
                                        <a href="" class="infosstem icon_observateur icon_info_contact" aria-hidden="true" data-toggle="modal" data-target="#InfoObservateurFor_{{ $user->id }}"><i class="fa fa-address-card-o" aria-hidden="true" ></i></a>

                                        <a href="javascript:void(0)" class="connected {{ $user->online }}"
                                           data-toggle="tooltip"
                                           data-placement="right"
                                           title="{{ $user->text_online }}"
                                        ><i class="fa fa-circle" aria-hidden="true"></i></a>
                                    </div>

                                </div>




                            </div>
                        </div>

                    @endforeach


                </div>
            </div>
        </div>

        @foreach ($users as $user)
                @if($user->id != Auth::user()->id && $user->active  == 1)
                    <div class="modal fade" id="SendMessageA_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" dir="rtl">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" dir="rtl">
                                    <h4 class="modal-title" id="myModalLabel">@lang('dossier.send_observateur')</h4>
                                </div>
                                <div class="modal-body">
                                    <p>@lang('dossier.send_l_observateur'){{ $user->roleuser->role->name }} : <strong>{{ $user->name }}</strong></p>
                                    <hr>
                                    <div class="form_send">
                                        <form>

                                            <div class="form-group">
                                                <label for="sujet_message">@lang('dossier.sujet_send')</label>
                                                <input type="text" id="sujet_message"  class="form-control" value="">
                                            </div>
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

                <div class="modal fade" id="InfoObservateurFor_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  dir="rtl">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" dir="rtl">
                                <h4 class="modal-title" id="myModalLabel">@lang('dossier.card_observateur')</h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <p class="text-center">
                                        <img src="{{ Request::root() }}/{{ $user->avatar }}" class="img-thumbnail img-user-profile">
                                    </p>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">


                                <h4 class="text-center"><strong>{{ $user->roleuser->role->name }}

                                @if($user->isAdmin())
                                    <span class="indicateur_observateur">{{ $user->roleuser->role->description }}</span>
                                @endif

                                @if($user->isObservateurRegional() || $user->isObservateur())
                                    <span class="indicateur_observateur">@lang('users.pour_gouvernorat') {{ $user->roleuser->gouvernorat->nom_gouvernorat }}</span>
                                @endif

                                @if($user->isObservateurSectorial())
                                    <span class="indicateur_observateur">@lang('users.pour_secteur') {{ $user->roleuser->secteur->nom_secteur }}</span>
                                @endif
                                    </strong>
                                </h4>

                                @if($user->active)
                                    <p class="indicateur_status_active text-center"><i class="fa fa-check" aria-hidden="true"></i> @lang('users.user_active')</p>
                                @else
                                    <p class="indicateur_status_inactive text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> @lang('users.user_inactive')</p>
                                @endif
                                </div>
                                <hr />
                                <p>@lang('users.prenom') : <strong>{{ $user->prnom }}</strong></p>
                                <p>@lang('users.nom') : <strong>{{ $user->nom }}</strong></p>
                                <p>@lang('users.email') : <strong class="miniscule">{{ $user->email }}</strong></p>
                                <p>@lang('users.societe') : <strong>
                                        @if( $user->societe != null)
                                            {{ $user->societe }}
                                        @else
                                            @lang('dossier.not_info')
                                        @endif
                                    </strong></p>
                                <p>@lang('users.structure_syndicale') : <strong>
                                        @if( $user->structure_syndicale == null )
                                            @lang('dossier.not_info')
                                        @else
                                            {{ $user->structure_syndicale->type_structure_syndicale }}
                                        @endif
                                    </strong></p>
                                <p>@lang('users.telephone') : <strong>
                                        @if( $user->phone_number != null)
                                            {{ $user->phone_number }}
                                        @else
                                            @lang('dossier.not_info')
                                        @endif
                                    </strong></p>
                                <p>@lang('users.email2') : <strong>
                                        @if( $user->email2 != null)
                                            {{ $user->email2 }}
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

        @endforeach



    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_contacts.js') }}"></script>
@endsection
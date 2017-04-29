@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/societes.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action" dir="rtl">

                        @if(Auth::user()->isAdmin())
                            <a class="retour_setting" href="{{ route('societes_region.admin', ['id_secteur' => $secteur->id, 'id_gouvernorat' => $delegation->gouvernorat->id]) }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.syndicats')"></i></a>
                        @endif

                        @if( Auth::user()->isObservateurRegional() OR Auth::user()->isObservateur() )
                            <a class="retour_setting" href="{{ route('societes_secteur.observateur_region', ['id_secteur' => $secteur->id]) }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.syndicats')"></i></a>
                        @endif

                        @if( Auth::user()->isObservateurSectorial() )
                            <a class="retour_setting" href="{{ route('societes_regional.observateur_secteur', ['id_gouvernorat' => $delegation->gouvernorat->id]) }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.syndicats')"></i></a>
                        @endif

                        <h3> @lang('societe.list_societees_pour_secteur') {{ $secteur->nom_secteur }} @lang('societe.list_societees_pour_delegation') {{ $delegation->nom_delegation }} @lang('societe.list_societees_pour_gouvernorat') {{ $delegation->gouvernorat->nom_gouvernorat }}  </h3>
                        <p class="text-muted">@lang('societe.description_list_societees_pour_secteur') <strong>{{ $secteur->nom_secteur }}</strong> @lang('societe.list_societees_pour_delegation') <strong>{{ $delegation->nom_delegation }}</strong> @lang('societe.list_societees_pour_gouvernorat') <strong>{{ $delegation->gouvernorat->nom_gouvernorat }}</strong> @lang('societe.nnb_societe') <strong>(<span class="count" >{{ $delegation->societesViaSecteur->count() }}</span>)</strong> .</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
            <div class="bg_detail"></div>


        </div>
    </div>

@endsection

@section('url_ajax')
    <input id="index" type="hidden" value="{{ route('json.region.societes.index', ['id_secteur' => $secteur->id, 'id_delegation' => $delegation->id]) }}">
    <input id="store" type="hidden" value="{{ route('societes.store') }}">

    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="edit nom_marque" dir="rtl" data-toggle="tooltip" data-placement="bottom" title="{nom_marque}">{nom_marque_limite}</span>
                        <span class="edit nom_societe" dir="rtl" data-toggle="tooltip" data-placement="top" title="{nom_societe}">{nom_societe_limite}</span>
                    </div>



                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="remove"
                           data-warning="@lang('main.etes_vous_sure')"
                           data-text-warning="@lang('societe.suppression_defenitife_societe')"
                           data-confirm-buttontext="@lang('main.confirmButtonText')"
                           data-cancel-buttonText="@lang('main.cancelButtonText')"
                           data-cancelled="@lang('main.cancelled')"
                        ><i class="fa fa-trash" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="edit"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('societe.societe_main')"></i></a>
                        <a href="javascript:void(0)" class="edit_conventions" data-toggle="tooltip" data-placement="top" title="@lang('societe.societe_convention')"><i class="fa fa-handshake-o" aria-hidden="true"></i></a>
                        <a href="{url_show_dossiers}" data-toggle="tooltip" data-placement="top" title="@lang('societe.display_dossiers_for_societees') {nb_dossiers}">{nb_dossiers} <i class="fa fa-archive" aria-hidden="true"></i></a>
                        <a href="{url_histrory_societe}" data-toggle="tooltip" data-placement="top" title="@lang('societe.histrory_societe')"><i class="fa fa-eye" aria-hidden="true"></i></a>



                    </div>


                </div>


                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')" data-id="{id}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nom_societe" placeholder="@lang('societe.nom_societe')" value="{nom_societe}" data-reset="{nom_societe}" required />
                        </div>

                        <div class="form-group m-t-8">
                            <input type="text" class="form-control" name="nom_marque" id="nom_marque" placeholder="@lang('societe.nom_marque')" value="{nom_marque}" data-reset="{nom_marque}" />
                        </div>

                        <div class="form-group m-t-8">
                            <select id="type_societe_id" name="type_societe_id" class="form-control" data-reset="{type_societe_id}">
                                <option value="">@lang('main.selectionnez')  @lang('societe.type_societe')</option>
                                @foreach ($types_societes as $type_societe)
                                    <option value="{{ $type_societe->id }}">{{ $type_societe->nom_type_societe }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.date_cration_societe')</label>
                            <input dir="ltr" type="text" class="form-control myDateFormat" name="date_cration_societe" id="date_cration_societe" placeholder="@lang('societe.exemple_format_date') 24/07/2003" value="{date_cration_societe}" data-reset="{date_cration_societe}" />
                        </div>

                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_edit"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="update_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>

                    </div>
                </div>

                <div class="form-box-conventions box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')" data-id="{id}">

                        <div class="form-group m-t-8">
                            <select id="accord_de_fondation" name="accord_de_fondation" class="form-control" data-reset="{accord_de_fondation}">
                                <option value="1">@lang('societe.accord_de_fondation_1')</option>
                                <option value="0" selected>@lang('societe.accord_de_fondation_0')</option>
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <select id="convention_cadre_commun" name="convention_cadre_commun" class="form-control" data-reset="{convention_cadre_commun}">
                                <option value="1" selected>@lang('societe.convention_cadre_commun_1')</option>
                                <option value="0">@lang('societe.convention_cadre_commun_0')</option>
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.convention')</label>
                            <select id="convention_id" name="convention_id" class="form-control" data-reset="{convention_id}">
                                <option value="0"> @lang('societe.pas_de_convontion')   </option>
                                @foreach ($secteur->conventions as $convention)
                                    <option value="{{ $convention->id }}">{{ $convention->nom_convention }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.nombre_travailleurs_cdi')</label>
                            <input dir="ltr" type="text" class="form-control" name="nombre_travailleurs_cdi" id="nombre_travailleurs_cdi" placeholder="@lang('societe.nombre_travailleurs_cdi')" value="{nombre_travailleurs_cdi}" data-reset="{nombre_travailleurs_cdi}" />
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.nombre_travailleurs_no_cdi')</label>
                            <input dir="ltr" type="text" class="form-control" name="nombre_travailleurs_cdd" id="nombre_travailleurs_cdd" placeholder="@lang('societe.nombre_travailleurs_no_cdi')" value="{nombre_travailleurs_cdd}" data-reset="{nombre_travailleurs_cdd}" />
                        </div>





                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_edit_conventions"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="update_conventions_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>

                    </div>
                </div>

                <div class="loader box"><i class='fa fa-spinner fa-spin'></i></div>

            </div>




        </div>
    </div>

    <div id="template_loading" class="hide">
        <div class='loading'></div>
    </div>

    <div id="template_form_add" class="hide">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-action">
            <div class="container_element">
                <a href="javascript:void(0)" class="box add">
                    <span class="fa fa-plus-circle"></span>
                    <span class="text">@lang('societe.add_societe')</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <input type="text" class="form-control" name="nom_societe" id="nom_societe" placeholder="@lang('societe.nom_societe')" value="" required />
                        </div>

                        <div class="form-group m-t-8">
                            <input type="text" class="form-control" name="nom_marque" id="nom_marque" placeholder="@lang('societe.nom_marque')" value="" />
                        </div>

                        <div class="form-group m-t-8">
                            <select id="type_societe_id" name="type_societe_id" class="form-control">
                                <option value="">@lang('main.selectionnez')  @lang('societe.type_societe')</option>
                                @foreach ($types_societes as $type_societe)
                                    <option value="{{ $type_societe->id }}">{{ $type_societe->nom_type_societe }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.date_cration_societe')</label>
                            <input dir="ltr" type="text" class="form-control myDateFormat" name="date_cration_societe" id="date_cration_societe" placeholder="@lang('societe.exemple_format_date') 24/07/2003" value="" />
                        </div>

                        <!------------------------------------------------------------------------------->
                        <div class="form-group m-t-8">
                            <select id="accord_de_fondation" name="accord_de_fondation" class="form-control">
                                <option value="1">@lang('societe.accord_de_fondation_1')</option>
                                <option value="0" selected>@lang('societe.accord_de_fondation_0')</option>
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <select id="convention_cadre_commun" name="convention_cadre_commun" class="form-control">
                                <option value="1" selected>@lang('societe.convention_cadre_commun_1')</option>
                                <option value="0">@lang('societe.convention_cadre_commun_0')</option>
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.convention')</label>
                            <select id="convention_id" name="convention_id" class="form-control">
                                <option value="0"> @lang('societe.pas_de_convontion')   </option>
                                @foreach ($secteur->conventions as $convention)
                                    <option value="{{ $convention->id }}">{{ $convention->nom_convention }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.nombre_travailleurs_cdi')</label>
                            <input dir="ltr" type="text" class="form-control" name="nombre_travailleurs_cdi" id="nombre_travailleurs_cdi" placeholder="@lang('societe.nombre_travailleurs_cdi')" value="0" />
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('societe.nombre_travailleurs_no_cdi')</label>
                            <input dir="ltr" type="text" class="form-control" name="nombre_travailleurs_cdd" id="nombre_travailleurs_cdd" placeholder="@lang('societe.nombre_travailleurs_no_cdi')" value="0" />
                        </div>

                        <!------------------------------------------------------------------------------->

                        <input type="hidden" id="delegation_id" value="{{ $delegation->id }}">
                        <input type="hidden" id="secteur_id" value="{{ $secteur->id }}">

                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_add"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="save_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>


                    </div>
                </div>

                <div class="loader box"><i class='fa fa-spinner fa-spin'></i></div>


            </div>


        </div>
    </div>


@endsection

@section('footer')
    <script src="{{ asset('js/management_societes.js') }}"></script>
@endsection
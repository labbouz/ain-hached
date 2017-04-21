@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/abus.css') }}" rel="stylesheet">
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
                <a href="{{ route('dossier.show', $dossier->id ) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('dossier.histrory_dossier')">
                    <i class="fa fa-eye" aria-hidden="true" ></i>
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
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action" dir="rtl">


                        <h3 dir="rtl"> @lang('abus.gestion_abus_number_file') {{ sprintf("%05d", $dossier->id) }} @lang('abus.abus_from') <strong>{{ $dossier->societe->nom_marque }}</strong>  </h3>
                        <p dir="rtl" class="text-muted">@lang('abus.description_gestion_abus').</p>
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
    <input id="index" type="hidden" value="{{ route('json.abus.index', $dossier->id) }}">
    <input id="store" type="hidden" value="{{ route('abus.store') }}">

    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="icon_abus"><i class="fa {class_color_type_violation} {class_color_gravite}" data-toggle="tooltip" data-placement="bottom"  title="@lang('abus.abu') {nom_gravite} {nom_type_violation}"></i></span>
                        <span class="edit nom_violation" dir="rtl">{nom_violation}</span>

                        <div class="info_abus">
                            <span class="date_abus" dir="rtl">@lang('abus.date_violation') <strong>{date_violation}</strong></span>
                        </div>
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
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('societe.display_dossiers_for_societees') {nb_confrontations_moves}">{nb_confrontations_moves} <i class="fa fa-archive" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('societe.histrory_societe')"><i class="fa fa-eye" aria-hidden="true"></i></a>


                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('societe.display_dossiers_for_societees') {nb_confrontations_moves}">{nb_confrontations_moves} <i class="fa fa-map-signs" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('societe.display_dossiers_for_societees') {nb_confrontations_plaintes}">{nb_confrontations_plaintes} <i class="fa fa-gavel" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="@lang('societe.display_dossiers_for_societees') {nb_confrontations_medias}">{nb_confrontations_medias} <i class="fa fa-bullhorn" aria-hidden="true"></i></a>



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


                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_edit"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="update_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>

                    </div>
                </div>

                <div class="form-box-conventions box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')" data-id="{id}">
                        {{--
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
                        --}}

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
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 container-action">
            <div class="container_element">
                <a href="javascript:void(0)" class="box add add1">
                    <span class="fa fa-user"></span>
                    <span class="text" dir="rtl"><i class="fa fa-plus"></i> @lang('abus.add_abus') @lang('violations.type_violation_1')</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <select id="violation_id" name="violation_id" class="form-control">
                                    <option value="">@lang('main.selectionnez') @lang('abus.violation')</option>
                                    @foreach ($types_violations_1->violations as $violation)
                                        <option value="{{ $violation->id }}">{{ $violation->nom_violation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.resultat')</label>
                                <select id="statut_reglement" name="statut_reglement" class="form-control">
                                    <option value="1">@lang('abus.resultat_ok')</option>
                                    <option value="0" selected>@lang('abus.resultat_not_ok')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.date_violation')</label>
                                <input dir="ltr" type="text" class="form-control myDateFormat" name="date_violation" id="date_violation" placeholder="@lang('abus.exemple_format_date') 24/07/2003" value="" />
                            </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.agresseur')</label>
                                <input type="text" class="form-control" name="prenom_agresseur" id="prenom_agresseur" placeholder="@lang('abus.prenom')" value="" />
                            </div>
                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="nom_agresseur" id="nom_agresseur" placeholder="@lang('abus.nom')" value="" />
                            </div>
                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="nationalite" id="nationalite" placeholder="@lang('abus.nationalite')" value="" />
                            </div>
                            <div class="form-group m-t-8">
                                <label>@lang('abus.responsabilite_represente_par')</label>
                            </div>
                            <div class="form-group">
                                <label>@lang('abus.responsabilite_represente_par_type_1')</label>
                                <select id="responsabilite_1" name="responsabilite_1" class="form-control">
                                    <option value="1">@lang('abus.oui')</option>
                                    <option value="0" selected>@lang('abus.non')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <label>@lang('abus.responsabilite_represente_par_type_2')</label>
                                <select id="responsabilite_2" name="responsabilite_2" class="form-control">
                                    <option value="1">@lang('abus.oui')</option>
                                    <option value="0" selected>@lang('abus.non')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <label>@lang('abus.responsabilite_represente_par_type_3')</label>
                                <select id="responsabilite_3" name="responsabilite_3" class="form-control">
                                    <option value="1">@lang('abus.oui')</option>
                                    <option value="0" selected>@lang('abus.non')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.endommage')</label>
                                <input type="text" class="form-control" name="prenom_endommage" id="prenom_endommage" placeholder="@lang('abus.prenom')" value="" required />
                            </div>
                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="nom_endommage" id="nom_endommage" placeholder="@lang('abus.nom')" value="" required />
                            </div>
                            <div class="form-group m-t-8">
                                <select id="structure_syndicale_id" name="structure_syndicale_id" class="form-control">
                                    <option value="">@lang('main.selectionnez') @lang('abus.structure_syndicale')</option>
                                    @foreach ($structures_syndicales as $structure_syndicale)
                                        <option value="{{ $structure_syndicale->id }}">{{ $structure_syndicale->type_structure_syndicale }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <select id="genre" name="genre" class="form-control">
                                    <option value="" selected>@lang('main.selectionnez') @lang('abus.genre')</option>
                                    <option value="male">@lang('abus.male')</option>
                                    <option value="feminin">@lang('abus.feminin')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <select id="age" name="age" class="form-control">
                                    <option value="0" selected>@lang('main.selectionnez') @lang('abus.age')</option>
                                    <option value="1">@lang('abus.age_type_1')</option>
                                    <option value="2">@lang('abus.age_type_2')</option>
                                    <option value="3">@lang('abus.age_type_3')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <select id="etat_civile" name="etat_civile" class="form-control">
                                    <option value="0" selected>@lang('main.selectionnez') @lang('abus.etat_civil')</option>
                                    <option value="1">@lang('abus.marie')</option>
                                    <option value="2">@lang('abus.unique')</option>
                                    <option value="3">@lang('abus.absolu')</option>
                                    <option value="4">@lang('abus.veuf')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <input dir="rtl" type="text" class="form-control" name="nb_enfant" id="nb_enfant" placeholder="@lang('abus.nombre_enfants_parrainage')" value="" />
                            </div>

                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="@lang('abus.telephone')" value="" />
                            </div>
                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="email" id="email" placeholder="@lang('abus.email')" value="" />
                            </div>
                            <div class="form-group m-t-8">
                                <select id="type_contrat" name="type_contrat" class="form-control">
                                    <option value="0" selected>@lang('main.selectionnez') @lang('abus.delimitation')</option>
                                    <option value="1">@lang('abus.delimitation_oui')</option>
                                    <option value="2">@lang('abus.delimitation_non')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <select id="anciennete" name="anciennete" class="form-control">
                                    <option value="0" selected>@lang('main.selectionnez') @lang('abus.la_responsabilite_seniority_syndicale')</option>
                                    <option value="1">@lang('abus.la_responsabilite_seniority_syndicale_type_1')</option>
                                    <option value="2">@lang('abus.la_responsabilite_seniority_syndicale_type_2')</option>
                                    <option value="3">@lang('abus.la_responsabilite_seniority_syndicale_type_3')</option>
                                    <option value="4">@lang('abus.la_responsabilite_seniority_syndicale_type_4')</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="dossier_id" id="dossier_id" value="{{ $dossier->id }}">

                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_add"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="save_element_1"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>


                    </div>
                </div>

                <div class="loader box"><i class='fa fa-spinner fa-spin'></i></div>


            </div>


        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 container-action">
            <div class="container_element">
                <a href="javascript:void(0)" class="box add add2">
                    <span class="fa fa-users"></span>
                    <span class="text" dir="rtl"><i class="fa fa-plus"></i> @lang('abus.add_abus') @lang('violations.type_violation_2')</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <select id="violation_id" name="violation_id" class="form-control">
                                    <option value="">@lang('main.selectionnez') @lang('abus.violation')</option>
                                    @foreach ($types_violations_2->violations as $violation)
                                        <option value="{{ $violation->id }}">{{ $violation->nom_violation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.resultat')</label>
                                <select id="statut_reglement" name="statut_reglement" class="form-control">
                                    <option value="1">@lang('abus.resultat_ok')</option>
                                    <option value="0" selected>@lang('abus.resultat_not_ok')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.date_violation')</label>
                                <input dir="ltr" type="text" class="form-control myDateFormat" name="date_violation" id="date_violation" placeholder="@lang('abus.exemple_format_date') 24/07/2003" value="" />
                            </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.agresseur')</label>
                                <input type="text" class="form-control" name="prenom_agresseur" id="prenom_agresseur" placeholder="@lang('abus.prenom')" value="" required />
                            </div>
                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="nom_agresseur" id="nom_agresseur" placeholder="@lang('abus.nom')" value="" required />
                            </div>
                            <div class="form-group m-t-8">
                                <input type="text" class="form-control" name="nationalite" id="nationalite" placeholder="@lang('abus.nationalite')" value="" required />
                            </div>
                            <div class="form-group m-t-8">
                                <label>@lang('abus.responsabilite_represente_par')</label>
                            </div>
                            <div class="form-group">
                                <label>@lang('abus.responsabilite_represente_par_type_1')</label>
                                <select id="responsabilite_1" name="responsabilite_1" class="form-control">
                                    <option value="1">@lang('abus.oui')</option>
                                    <option value="0" selected>@lang('abus.non')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <label>@lang('abus.responsabilite_represente_par_type_2')</label>
                                <select id="responsabilite_2" name="responsabilite_2" class="form-control">
                                    <option value="1">@lang('abus.oui')</option>
                                    <option value="0" selected>@lang('abus.non')</option>
                                </select>
                            </div>
                            <div class="form-group m-t-8">
                                <label>@lang('abus.responsabilite_represente_par_type_3')</label>
                                <select id="responsabilite_3" name="responsabilite_3" class="form-control">
                                    <option value="1">@lang('abus.oui')</option>
                                    <option value="0" selected>@lang('abus.non')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group m-t-8">
                                <label>@lang('abus.endommage')</label>
                                <select id="structure_syndicale_id" name="structure_syndicale_id" class="form-control">
                                    <option value="">@lang('main.selectionnez') @lang('abus.structure_syndicale')</option>
                                    @foreach ($structures_syndicales as $structure_syndicale)
                                        <option value="{{ $structure_syndicale->id }}">{{ $structure_syndicale->type_structure_syndicale }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <input type="hidden" name="dossier_id" id="dossier_id" value="{{ $dossier->id }}">

                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_add"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="save_element_2"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>


                    </div>
                </div>

                <div class="loader box"><i class='fa fa-spinner fa-spin'></i></div>


            </div>


        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('js/management_abus.js') }}"></script>
@endsection
@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/accrochages.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action">
                        <a class="retour_setting" href="{{ URL::previous() }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.retour_previous')"></i></a>
                        <h3> @lang('abus.accrochages_moves')  </h3>
                        <p class="text-muted" dir="rtl">
                            @lang('abus.dossier_numero') <strong>{{ sprintf("%05d", $abus->dossier->id) }}</strong><br>
                            @lang('abus.societe_syndical') <strong>{{ $abus->dossier->societe->nom_societe }}</strong><br>
                            @lang('abus.violation') <strong> {{ $abus->violation->nom_violation }}</strong><br>
                            @lang('abus.date_violation') <strong> {{ $abus->date_violation }}</strong><br>
                            @lang('abus.endommage') <strong> {{ $abus->endommage->prenom }} {{ $abus->endommage->nom }} /  {{ $abus->endommage->structure_syndicale->type_structure_syndicale }}</strong><br>
                            @lang('abus.agresseur') <strong> {{ $abus->agresseur->prenom }} {{ $abus->agresseur->nom }}</strong>
                        </p>
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
    <input id="index" type="hidden" value="{{ route('json.accrochages_moves.index', $abus->id) }}">
    <input id="store" type="hidden" value="{{ route('accrochages_moves.store') }}">

    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="edit" dir="rtl">{nom_accrochage}</span>
                    </div>

                    <div class="toolbar_box"  dir="rtl">
                        <span id="display_date_accrochage" class="date_accrochage">{date_accrochage}</span>
                        <a href="javascript:void(0)" class="remove"
                           data-warning="@lang('main.etes_vous_sure')"
                           data-text-warning="@lang('abus.suppression_defenitife')"
                           data-confirm-buttontext="@lang('main.confirmButtonText')"
                           data-cancel-buttonText="@lang('main.cancelButtonText')"
                           data-cancelled="@lang('main.cancelled')"
                        ><i class="fa fa-trash" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </div>


                </div>


                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')" data-id="{id}">
                        <div class="form-group">
                            <select id="move_id" name="move_id" class="form-control" data-reset="{move_id}">
                                <option value="0">@lang('main.selectionnez')  @lang('abus.accrochages')</option>
                                @foreach ($moves as $move)
                                    <option value="{{ $move->id }}">{{ $move->nom_move }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('abus.date_accrochage')</label>
                            <input dir="ltr" type="text" class="form-control myDateFormat" name="date_accrochage" id="date_accrochage" placeholder="@lang('abus.exemple_format_date') 24/07/2003" data-reset="{date_accrochage}" value="{date_accrochage}" />
                        </div>

                        <div class="form-group m-t-8">
                            <textarea  class="form-control" name="description_accrochage" id="description_accrochage" placeholder="@lang('abus.description_accrochage')" data-reset="{description_accrochage}">{description_accrochage}</textarea>
                        </div>

                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_edit"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="update_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>

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
                    <span class="text">@lang('abus.add_accrochages')</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <select id="move_id" name="move_id" class="form-control">
                                <option value="0">@lang('main.selectionnez')  @lang('abus.accrochages')</option>
                                @foreach ($moves as $move)
                                    <option value="{{ $move->id }}">{{ $move->nom_move }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-8">
                            <label>@lang('abus.date_accrochage')</label>
                            <input dir="ltr" type="text" class="form-control myDateFormat" name="date_accrochage" id="date_accrochage" placeholder="@lang('abus.exemple_format_date') 24/07/2003" value="" />
                        </div>

                        <div class="form-group m-t-8">
                            <textarea  class="form-control" name="description_accrochage" id="description_accrochage" placeholder="@lang('abus.description_accrochage')"></textarea>
                        </div>

                        <input type="hidden" name="abu_id" id="abu_id" value="{{ $abus->id }}">
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
    <script src="{{ asset('js/management_accrochages_moves.js') }}"></script>
@endsection
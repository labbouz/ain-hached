@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/types_societes.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action">
                        <a class="retour_setting" href="{{ route('setting') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.configuration')"></i></a>
                        <h3> @lang('societe.types_societes')  </h3>
                        <p class="text-muted">@lang('societe.description_types_societes')</p>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">


        </div>
    </div>

@endsection

@section('url_ajax')
    <input id="index" type="hidden" value="{{ route('json.type_societe.index') }}">
    <input id="store" type="hidden" value="{{ route('type_societe.store') }}">

    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="edit" dir="rtl">{nom_type_societe}</span>
                    </div>



                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="remove"
                           data-warning="@lang('main.etes_vous_sure')"
                           data-text-warning="@lang('societe.suppression_defenitife')"
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
                            <input type="text" class="form-control" name="nom_type_societe" id="nom_type_societe" placeholder="@lang('societe.type_societe_nom')" value="{nom_type_societe}" data-error="@lang('main.info_monquant')" data-reset="{nom_type_societe}" required />
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
                    <span class="text">@lang('societe.add_type_societe')</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <input type="text" class="form-control" name="nom_type_societe" id="nom_type_societe" placeholder="@lang('societe.type_societe_nom')" value="" data-error="@lang('main.info_monquant')" required />
                        </div>

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
    <script src="{{ asset('js/management_types_societes.js') }}"></script>
@endsection
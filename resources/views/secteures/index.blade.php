@extends('layouts.app')

@section('header')
    <link href="/css/pages/secteurs.css" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action">
                        <h3> @lang('secteur.secteurs')  </h3>
                        <p class="text-muted">@lang('secteur.description_secteurs')</p>
                    </div>

                    <div id="header_add" class="header_action">
                        <h3> @lang('secteur.add_secteur')  </h3>
                        <p class="text-muted">@lang('secteur.detail_secteur_edit')</p>
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
    <input id="index" type="hidden" value="{{ route('json.secteurs.index') }}">
    <input id="store" type="hidden" value="{{ route('secteurs.store') }}">
    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element box">

                <div class="container_element card">
                    <div class="label_elemen">
                        <span class="edit">{nom_secteur}</span>
                    </div>



                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </div>


                </div>


                <div class="form-box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nom_secteur" placeholder="@lang('secteur.secteur_nom')" value="" data-error="@lang('main.info_monquant')" required />
                        </div>
                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_element"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="save_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>

                    </div>
                </div>

                <div class="loader"><i class='fa fa-spinner fa-spin'></i></div>

            </div>




        </div>
    </div>

    <div id="template_loading" class="hide">
        <div class='loading'></div>
    </div>

    <div id="template_form_add" class="hide">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-action">
            <div class="container_element box">
                <a href="javascript:void(0)" class="add">
                    <span class="fa fa-plus-circle"></span>
                    <span class="text">@lang('secteur.add_secteur')</span>
                </a>

                <div class="form-box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nom_secteur" placeholder="@lang('secteur.secteur_nom')" value="" data-error="@lang('main.info_monquant')" required />
                        </div>
                    </form>

                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="cancel_element"><i class="fa fa-times" aria-hidden="true"></i> @lang('main.cancel')</a>
                        <a href="javascript:void(0)" class="save_element"><i class="fa fa-floppy-o" aria-hidden="true"></i> @lang('main.save')</a>

                    </div>
                </div>

                <div class="loader"><i class='fa fa-spinner fa-spin'></i></div>


            </div>


        </div>
    </div>


@endsection

@section('footer')
    <script src="/js/management_secteurs.js"></script>
@endsection
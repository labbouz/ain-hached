@extends('layouts.app')

@section('header')
    <link href="/css/pages/structures_syndicales.css" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action">
                        <a class="retour_setting" href="{{ route('setting') }}"><i class="fa fa-reply" aria-hidden="true"></i></a>
                        <h3> @lang('syndicale.structures_syndicales')  </h3>
                        <p class="text-muted">@lang('syndicale.description_structures_syndicales')</p>
                    </div>

                    <div id="header_add" class="header_action">
                        <h3> @lang('syndicale.add_structure_syndicale')  </h3>
                        <p class="text-muted">@lang('syndicale.detail_structure_syndicale_edit')</p>
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
    <input id="index" type="hidden" value="{{ route('json.structure_syndicale.index') }}">
    <input id="store" type="hidden" value="{{ route('structure_syndicale.store') }}">

    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="edit" dir="rtl">{type_structure_syndicale}</span>
                    </div>



                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="remove"
                           data-warning="@lang('main.etes_vous_sure')"
                           data-text-warning="@lang('syndicale.suppression_defenitife')"
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
                            <input type="text" class="form-control" id="type_structure_syndicale" placeholder="@lang('syndicale.type_structure_syndicale_nom')" value="{type_structure_syndicale}" data-error="@lang('main.info_monquant')" data-reset="{type_structure_syndicale}" required />
                        </div>
                        <div class="form-group m-t-8">
                            <textarea  class="form-control" id="description_type" placeholder="@lang('syndicale.description_type_structure_syndicale')" data-reset="{description_type}">{description_type}</textarea>
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
                    <span class="text">@lang('syndicale.add_structure_syndicale')</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <input type="text" class="form-control" id="type_structure_syndicale" placeholder="@lang('syndicale.type_structure_syndicale_nom')" value="" data-error="@lang('main.info_monquant')" required />
                        </div>

                        <div class="form-group m-t-8">
                            <textarea  class="form-control" id="description_type" placeholder="@lang('syndicale.description_type_structure_syndicale')"></textarea>
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
    <script src="/js/management_structures_syndicales.js"></script>
@endsection
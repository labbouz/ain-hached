@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/users.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action" dir="rtl">
                        <a class="retour_setting" href="{{ route('users.index') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.users')"></i></a>


                        <h3> @lang('users.list_users_roles_admins')   </h3>
                        <p class="text-muted">@lang('users.desc_list_users_roes') <strong>{{ $role->name }}</strong>  @lang('users.count_users') <strong>(<span class="count" >{{ $role->users->count() }}</span>)</strong> @lang('users.observateur').</p>
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
    {{--
    {{ route('json.users.index', ['id_role' => $role->id, 'id_inicateur' => $secteure->id] ) }}
    --}}

    <input id="index" type="hidden" value="{{ route('json.users.index', ['id_role' => $role->id] ) }}">
    <input id="store" type="hidden" value="{{ route('users.store') }}">

    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="container_element">

                <div class="edit_card card box">
                    <div class="label_elemen">
                        <span class="edit info" dir="rtl">{name}</span>
                        <span class="profile">
                            <img data-origin="{{ Request::root() }}/{avatar}" src="{{ asset('images/avatars/anonyme.jpg') }}" alt="user-img" class="img-circle img-responsive">
                        </span>
                    </div>



                    <div class="toolbar_box"  dir="rtl">
                        <a href="javascript:void(0)" class="remove"
                           data-warning="@lang('main.etes_vous_sure')"
                           data-text-warning="@lang('users.suppression_defenitife_user')"
                           data-confirm-buttontext="@lang('main.confirmButtonText')"
                           data-cancel-buttonText="@lang('main.cancelButtonText')"
                           data-cancelled="@lang('main.cancelled')"

                           data-toggle="tooltip"
                           data-placement="top"
                           title="@lang('users.remove_user')"
                        ><i class="fa fa-trash" aria-hidden="true"></i></a>

                        <a href="javascript:void(0)" class="edit"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="@lang('users.update_user')"
                        ><i class="fa fa-pencil" aria-hidden="true"></i></a>

                        <a href="javascript:void(0)" class="changepass"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="@lang('users.changepass_user')"><i class="fa fa-lock" aria-hidden="true"></i></a>

                        <a href="javascript:void(0)" class="infosstem"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="@lang('users.update_info_user')"><i class="fa fa-info" aria-hidden="true"></i></a>

                        <a href="javascript:void(0)" class="avatar"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="@lang('users.changeavatar_user')"><i class="fa fa-camera" aria-hidden="true"></i></a>
                    </div>


                </div>


                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')" data-id="{id}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="prnom" id="prnom" placeholder="@lang('users.prenom')" value="{prnom}" data-reset="{prnom}" required />
                        </div>
                        <div class="form-group m-t-8">
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="@lang('users.nom')" value="{nom}" data-reset="{nom}" required />
                        </div>

                        <div class="form-group m-t-8">
                            <input type="email" class="form-control" name="email" id="email" placeholder="@lang('users.email')" value="{email}" data-reset="{email}" required />
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
                    <span class="text">@lang('users.add_') {{ $role->name }}</span>
                </a>

                <div class="form-box box">
                    <form autocomplete="off" class="form-cart" dir="rtl" data-error="@lang('main.info_monquant')">
                        <div class="form-group">
                            <input type="text" class="form-control" name="prnom" id="prnom" placeholder="@lang('users.prenom')" value="" required />
                        </div>
                        <div class="form-group m-t-8">
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="@lang('users.nom')" value="" required />
                        </div>

                        <div class="form-group m-t-8">
                            <input type="email" class="form-control" name="email" id="email" placeholder="@lang('users.email')" value="" required />
                        </div>

                        <div class="form-group m-t-8">
                            <input type="password" class="form-control" name="password" id="password" placeholder="@lang('users.password')" value="" required />
                        </div>
                        <div class="form-group m-t-8">
                            <input type="password" class="form-control" name="password_confirm" id="password-confirm" placeholder="@lang('users.confirm_password')" value="" required />
                        </div>

                        <input type="hidden" id="role_id" value="{{ $role->id }}">
                        <input type="hidden" id="secteur_id" value="0">
                        <input type="hidden" id="gouvernorat_id" value="0">

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
    <script src="{{ asset('js/management_users.js') }}"></script>
@endsection
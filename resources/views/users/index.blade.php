@extends('layouts.app')

@section('header')
    <link href="/css/pages/users.css" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_loading" class="header_action header_action_active"></div>

                    <div id="header_index" class="header_action">
                        <h3> @lang('users.users')  </h3>
                        <p class="text-muted">@lang('users.info_list_users')</p>
                    </div>

                    <div id="header_add" class="header_action">
                        <h3> @lang('main.add_user')  </h3>
                        <p class="text-muted"><strong>@lang('users.details_user')</strong> : @lang('users.desc_details_user')</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row tool_bar_action">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-action">
                <a href="javascript:void(0)" class="add box">
                    <span class="fa fa-user-plus"></span>
                    <span class="text">@lang('main.add_user')</span>
                </a>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-action hide">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <input type="search" class="form-control" id="input-search" placeholder="Rechercher..." autocomplete="off">
                </form>
            </div>

        </div>
        <div id="list_elements" class="row"></div>
        <div id="espace_form" class="row"></div>
    </div>

@endsection

@section('url_ajax')
    <input id="index" type="hidden" value="{{ route('json.users.index') }}">
    {{ csrf_field() }}

    <div id="template_container" class="hide">
        <div id="id_{id}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
            <div class="text-right card box">
                <span>{name}</span>
                <span>{email}</span>
            </div>
        </div>
    </div>

    <div id="template_loading" class="hide">
        <div class='loading'></div>
    </div>

    <div id="template_form_add" class="hide">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <form autocomplete="off" class="form-cart" dir="rtl">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder="@lang('users.name_user')" value="" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="@lang('users.email')" value="" />
                </div>
                <div class="form-group">
                    <select class="form-control" id="role_id">
                        <option value="0" selected disabled hidden>@lang('users.droits')</option>
                        <option value="1">@lang('users.role_admin')</option>
                        <option value="2">@lang('users.role_observateur_regional')</option>
                        <option value="3">@lang('users.role_observateur_secteur')</option>
                        <option value="4">@lang('users.role_observateur')</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="@lang('users.password')">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password-confirm" placeholder="@lang('users.confirm_password')">
                </div>

                <div class="form-group">

                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary">
                            @lang('main.save')
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary">
                            @lang('main.cancel')
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>


@endsection

@section('footer')
    <script src="/js/management.js"></script>
@endsection
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
                    @foreach ($roles as $role)
                        <div class="has-rtl has_{{ $role->class_color }}">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="checkboxSuccess" value="{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                        </div>
                     @endforeach
                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-sm12 col-xs-12">
                <div id="list_elements" class="row">
                    @foreach ($users as $user)
                        <div id="id_{{ $user->id }}" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 container-card">
                            <div class="container_element">

                                <div class="edit_card card box">
                                    <div class="label_elemen">
                                        <span class="status_active user_{{ $user->active }}">
                                            <i class="fa fa-check" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="@lang('users.user_active')"></i>
                                            <i class="fa fa-times" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="@lang('users.user_inactive')"></i>
                                        </span>
                                        <span class="edit info" dir="rtl">{{ $user->name }}</span>
                                            <span class="profile change_avatar">
                                            <img data-origin="{{ Request::root() }}/{{ $user->avatar }}" src="{{ asset('images/avatars/anonyme.jpg') }}" alt="user-img" class="img-circle img-responsive">
                                        </span>
                                    </div>

                                    <div class="toolbar_box"  dir="rtl">
                                         <a href="javascript:void(0)" class="infosstem"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="@lang('users.update_info_user')"><i class="fa fa-info" aria-hidden="true"></i></a>

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



    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_contacts.js') }}"></script>
@endsection
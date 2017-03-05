@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/roles.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('home') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.dashboard')"></i></a>
                        <h3> @lang('users.droits')  </h3>
                        <p class="text-muted">@lang('users.description_list_droits')</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
        @foreach ($roles as $role)
                <div id="id_{{ $role->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
                    <div class="container_element">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <span class="edit" dir="rtl">{{ $role->name }}</span>
                                <i class="info_bloc fa fa-info-circle {{ $role->class_color }}" data-toggle="tooltip" data-placement="top" title="{{ $role->description }}" aria-hidden="true"></i>
                            </div>
                            <div class="toolbar_box"  dir="rtl">

                                <a href="{{ route('roles.display',$role->id ) }}">

                                    @lang('users.list_observateurs')  : {{ $role->users->count() }} <i class="fa fa-users" aria-hidden="true"  @if ($role->users->count() > 0 ) data-toggle="tooltip"  data-placement="top" title="
                                @foreach ($role->users as $role_user)

                                    @if($role->users->first() == $role_user)
                                        {{ $role_user->user->name }}
                                    @else
                                            - {{ $role_user->user->name }}
                                    @endif

                                    @endforeach"


                                    @endif
                                    ></i>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_roles.js') }}"></script>
@endsection
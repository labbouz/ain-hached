@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/gouvernorats.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('users.index') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.users')"></i></a>
                        <h3> {{ $titre_label }}  </h3>
                        <p class="text-muted">{{ $role->name }} : {{ $role->description }}</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
        @foreach ($gouvernorats as $gouvernorat)
                <div id="id_{{ $gouvernorat->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
                    <div class="container_element">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <span class="edit" dir="rtl">{{ $gouvernorat->nom_gouvernorat }}</span>
                            </div>
                            <div class="toolbar_box"  dir="rtl">

                                @if($gouvernorat->users_roles->count() > 0 )
                                    <a href="{{ route('users.display', ['id_role' => $role->id, 'id_inicateur' => $gouvernorat->id] ) }}">@lang('users.nb_observateurs')  : {{ $gouvernorat->users_roles->count() }}

                                        <i class="fa fa-users" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="
                                    @foreach ($gouvernorat->users_roles as $roleuser)

                                        @if($gouvernorat->users_roles->first() == $roleuser)
                                        {{ $roleuser->user->name }}
                                        @else
                                                - {{ $roleuser->user->name }}
                                        @endif

                                     @endforeach
                                    "></i>

                                    </a>
                                @else
                                    <a href="{{ route('users.display', ['id_role' => $role->id, 'id_inicateur' => $gouvernorat->id] ) }}">@lang('users.nb_observateurs')  : {{ $gouvernorat->users_roles->count() }}
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </a>
                                @endif

                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_users.js') }}"></script>
@endsection